<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score as MainModel;
use App\Models\Subject;
use App\Models\User;
use App\Models\RequestEditScore;
use App\Models\Classroom;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function viewSubjects()
    {
        $data['classes'] = Classroom::all();
        $data['rows'] = Subject::all();
        $data['students'] = StudentProfile::with('user')->get();
        return view('scores.subject.list', $data);
    }

    public function bySubject($id)
    {
        $data['rows'] = MainModel::where('subject_id', $id)->get();
        $data['rec'] = Subject::findOrFail($id);
        return view('scores.subject.index', $data);
    }

    public function viewStudents()
    {
        $data['rows'] = StudentProfile::with('user')->get();
        return view('scores.student.list')->with($data);
    }

    public function byStudent($id)
    {
        $student = StudentProfile::where('user_id', $id)->firstOrFail();
        $data['rows'] = MainModel::where('student_profile_id', $student->id)->get();
        $data['rec'] = $student;
        return view('scores.student.index', $data);
    }

    public function thisSubjectStudent($student_id, $class_id)
    {
        $rec = StudentProfile::findOrFail($student_id);
        $rows = MainModel::with('classroom.subject')->where('student_profile_id', $student_id)->get();

        return view('scores.student.index', compact ('rec','rows'));
    }

    public function viewSemesters()
    {
        if(auth()->user()->role == 'student') {
            $user = auth()->user();
            $semesters = [];
            $scores = MainModel::where('student_profile_id', $user->profile->id)->get();
            foreach($scores as $score) {
                if(!in_array($score->subject->semester, $semesters))
                    $semesters[] = $score->subject->semester;
            }
            sort($semesters);
            foreach($semesters as $index => $semester) {
                $semesters[$index] = ['semester' => $semester];
            }
            $data['rows'] = $semesters;
        } else
            $data['rows'] = Subject::select('semester')->distinct()->orderBy('semester', 'DESC')->get();
        return view('scores.semester.list', $data);
    }

    public function bySemester(Request $request, $semester)
    {
        $classID = Subject::where('semester', $semester)->pluck('id');
        $rows = MainModel::with('classroom.subject', 'student')->whereIn('class_id', $classID)->get();

        return view('scores.semester.index', [
            'rec' => $semester,
            'rows' => $rows
        ]);
    }

    public function viewClassrooms()
    {
        $data['rows'] = Classroom::all();
        return view('scores.classroom.list', $data);
    }

    public function byClassroom($classId)
{
    // Lấy danh sách sinh viên thuộc lớp này
    $rec  = Classroom::findOrFail($classId);
    $students = StudentProfile::whereHas('classrooms', function($q) use ($classId) {
            $q->where('classroom_id', $classId);
        })
        ->with(['scores' => function($q) use ($classId) {
            $q->where('class_id', $classId);
        }])
        ->orderByRaw("SUBSTRING_INDEX(name, ' ', -1)") // sắp xếp theo tên cuối
        ->get();

    return view('scores.classroom.index', [
        'rec'      => $rec,
        'students' => $students,
        'classId'  => $classId
    ]);
}


    public function add()
    {
        $data['rows'] = StudentProfile::with('user')->get();
        return view('scores.form')->with($data);
    }

    // public function create(Request $request)
    // {
    //     try {
    //         $params = $request->all();
    //         DB::transaction(function () use ($params) {
    //             MainModel::create([
    //                 'student_profile_id' => $params['student_profile_id'],
    //                 'class_id' => $params['class_id'],
    //                 'tp1' => $params['tp1'],
    //                 'tp2' => $params['tp2'],
    //                 'qt' => $params['qt'],
    //                 'ck' => $params['ck'],
    //                 'tk' => ($params['tp1']+$params['tp2'])*10/100 + $params['qt']*40/100 + $params['ck']*0.5,
    //             ]);
    //         });
    //         return redirect()->route('scores.students')->withSuccess("Đã thêm");
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withError($e->getMessage())->withInput();
    //     }
    // }

    public function edit($classId)
    {
        $class = Classroom::with(['students.scores' => function($q) use ($classId) {
            $q->where('class_id', $classId);
        }])->findOrFail($classId);

        return view('scores.form', compact('class', 'classId'));
    }

    public function update(Request $request, $classId){
        foreach ($request->scores as $studentId => $scoreData) {
            $tp1 = $scoreData['tp1'] ?? null;
            $tp2 = $scoreData['tp2'] ?? null;
            $qt  = $scoreData['qt'] ?? null;
            $ck  = $scoreData['ck'] ?? null;

            $tk = null;
            if (!is_null($tp1) && !is_null($tp2) && !is_null($qt) && !is_null($ck)) {
                $tk = ($tp1 + $tp2) * 0.1 + $qt * 0.4 + $ck * 0.5;
            }
            MainModel::updateOrCreate(
                [
                    'student_profile_id' => $studentId,
                    'class_id' => $classId,
                ],
                [
                    'tp1' => $tp1,
                    'tp2' => $tp2,
                    'qt'  => $qt,
                    'ck'  => $ck,
                    'tk'  => $tk,
                ]
            );
        }

        return redirect()->route('scores.students', $classId)
                        ->with('success', 'Cập nhật điểm thành công!');
    }

    public function delete($id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $rec->delete();
            return redirect()->back()->withSuccess("Đã xóa");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
