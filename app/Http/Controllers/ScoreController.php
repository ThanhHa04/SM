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
        $data['rows'] = MainModel::where('student_profile_id', $id)->get();
        $data['rec'] = StudentProfile::findOrFail($id);
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

    public function byClassroom(Request $request, $id)
    {
        $data['rec'] = Classroom::findOrFail($id);
        $data['rows'] = MainModel::all();
        $data['rows_filtered'] = [];
        foreach ($data['rows'] as $row) {
            if ($row->classroom->id == $id) {
                array_push($data['rows_filtered'], $row);
            }
        }
        $data['rows'] = $data['rows_filtered'];
        return view('scores.classroom.index', $data);
    }

    public function add()
    {
        $data['classes'] = Classroom::all();
        $data['students'] = StudentProfile::with('user')->get();
        return view('scores.form')->with($data);
    }

    public function create(Request $request)
    {
        try {
            $params = $request->all();
            DB::transaction(function () use ($params) {
                MainModel::create([
                    'student_profile_id' => $params['student_profile_id'],
                    'class_id' => $params['class_id'],
                    'tp1' => $params['tp1'],
                    'tp2' => $params['tp2'],
                    'qt' => $params['qt'],
                    'ck' => $params['ck'],
                    'tk' => ($params['tp1']+$params['tp2'])*10/100 + $params['qt']*40/100 + $params['ck']*0.5,
                ]);
            });
            return redirect()->route('scores.students')->withSuccess("Đã thêm");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data['classes'] = Classroom::all();
        $data['students'] = User::where('role', 'student')->get();
        $data['rec'] = MainModel::findOrFail($id);
        return view('scores.form')->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $params = $request->all();
            DB::transaction(function () use ($params, $rec) {
                $rec->update($params);
            });
            return redirect()->route('scores.students')->withSuccess("Đã cập nhật");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
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
