<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classroom as MainModel;
use Illuminate\Support\Facades\DB;
use App\Models\ClassroomStudent;
use App\Models\Subject;
use App\Models\User;
use App\Models\TeacherSubject;
use App\Models\TeacherProfile;
use App\Models\StudentProfile;

class ClassroomController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $data['rows'] = MainModel::all();
            $data['totalClass'] = MainModel::count();
        } elseif ($user->role === 'teacher') {
            // Chỉ lấy các lớp mà giáo viên đảm nhiệm
            $teacherId = $user->teacherProfile->id;
            $data['rows'] = MainModel::where('teacher_profile_id', $teacherId)->get();
            $data['totalClass'] = $data['rows']->count();
        } elseif ($user->role === 'student') {
            // Chỉ lấy các lớp mà sinh viên đang học
            $studentId = $user->studentProfile->id;
            $data['rows'] = MainModel::whereHas('students', function($q) use ($studentId) {
                $q->where('student_profile_id', $studentId);
            })->get();
            $data['totalClass'] = $data['rows']->count();
        } else {
            $data['rows'] = collect();
            $data['totalClass'] = 0;
        }

        $data['enableSearch'] = true;
        $data['searchRoute'] = route('classes.search');

        return view('classes.index', $data);
    }

    public function search(Request $request)
    {
        $query = MainModel::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', "%$keyword%");
        }

        $data['rows'] = $query->get();
        $data['totalClass'] = $query->count();
        $data['enableSearch'] = true;

        return view('classes.index')->with($data);
    }
    
    public function add()
    {
        $subjects = Subject::all();
        $teachers = TeacherProfile::with('user')->get();
        $students = StudentProfile::with('user')->get();
        
        return view('classes.form', [
            'subjects' => $subjects,
            'teachers' => $teachers,
            'students' => $students,
        ]);
    }

    public function view($classroom_id) {
        $classroom = MainModel::with('teacher.user')->findOrFail($classroom_id);
        $classroom_students = ClassroomStudent::with('student.user')->where('classroom_id',$classroom_id)->get();
        return view('classes.class_info', compact('classroom_students','classroom'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:classes,name',
        ], [
            'name.unique' => 'Tên lớp này đã tồn tại',
        ]);
        try {
            $params = $request->all();
            DB::transaction(function () use ($params) {
                $rec = MainModel::create([
                'subject_id' => $params['subject_id'],
                'name' => $params['name'],
                'teacher_profile_id' => $params['teacher_profile_id'] ?? null,
            ]);
                if(isset($params['student_profile_id']))
                    foreach($params['student_profile_id'] as $row)
                        ClassroomStudent::create(['classroom_id' => $rec->id, 'student_profile_id' => $row]);
            });
            return redirect()->route('classes')->withSuccess("Đã thêm");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data['rec'] = MainModel::findOrFail($id);
        $data['subjects'] = Subject::all();
        $data['teachers'] = TeacherProfile::with('user')->get();
        $data['students'] = StudentProfile::with('user')->get();
        $data['student_list'] = ClassroomStudent::where('classroom_id', $id)->get();
        return view('classes.form')->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $params = $request->all();
            DB::transaction(function () use ($params, $rec) {
                $student_list = $rec->students;
                foreach($student_list as $row)
                    $rec->update([
                    'subject_id' => $params['subject_id'],
                    'name' => $params['name'],
                    'teacher_profile_id' => $params['teacher_profile_id'],
                ]);
                if (isset($params['student_profile_id'])) {
                    $rec->students()->sync($params['student_profile_id']);  
                }
            });
            return redirect()->route('classes')->withSuccess("Đã cập nhật");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            if($rec->students->count() > 0)
                throw new \Exception('Bạn phải chuyển hết sinh viên ra khỏi lớp trước khi xóa lớp');
            $rec->delete();
            return redirect()->back()->withSuccess("Đã xóa");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
