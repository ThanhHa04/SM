<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User as MainModel;
use App\Models\StudentProfile;
use App\Models\Classroom;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $data['rows'] = StudentProfile::with('user')->get();
        return view('students.index')->with($data);
    }

    private function generateStudentId(): string
    {
        $year = date('y');
        $studentID = 'S' . $year . '0';
        $latest = MainModel::where('role', 'student')->orderByDesc('profile_id')->value('profile_id');
        $nextIndex = $latest + 1;
        return $studentID . $nextIndex;
    }


    public function add()
    {
        $data['classes'] = Classroom::all();
        $data['student_id'] = $this->generateStudentId();
        return view('students.form')->with($data);
    }

    public function create(Request $request){
        try {
            $params = $request->all();
            $params['password'] = Hash::make($params['password']);
            $params['student_id'] = $this->generateStudentId();
            $params['role'] = 'student';
            DB::transaction(function () use ($params) {
                $profile = StudentProfile::create([
                    'name'         => $params['name'],
                    'dob'          => $params['dob'],
                    'email'        => $params['email'],
                    'phone_number' => $params['phone_number'],
                    'student_id'   => $params['student_id'],
                ]);
                $params['profile_id'] = $profile->id;
                MainModel::create([
                    'name'       => $params['name'],
                    'username'   => $params['student_id'],
                    'email'      => $params['email'],
                    'password'   => $params['password'],
                    'role'       => $params['role'],
                    'profile_id' => $profile->id,
                ]);
            });
            return redirect()->route('students')->withSuccess("Đã thêm");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data['classes'] = Classroom::all();
        $data['rec'] = StudentProfile::with('user')->findOrFail($id);
        return view('students.form')->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $params = $request->all();
            if(strlen($params['password']))
                $params['password'] = Hash::make($params['password']);
            else
                unset($params['password']);
            $params['username'] = $params['student_id'];
            $params['role'] = 'student';
            DB::transaction(function () use ($params, $rec) {
                $rec->profile->update($params);
                $rec->update($params);
            });
            return redirect()->route('students')->withSuccess("Đã cập nhật");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function delete($id) {
        try {
            $rec = MainModel::findOrFail($id);
            $rec->profile->delete();
            $rec->delete();
            return redirect()->back()->withSuccess("Đã xóa");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function showClassroom($id)
    {
        $student = StudentProfile::with('user', 'classrooms')->findOrFail($id);
        $classes = $student->classrooms;
            
        // SELECT classrooms.*
        // FROM classrooms
        // JOIN classroom_student
        // ON classroom_student.classroom_id = classrooms.id
        // WHERE classroom_student.student_profile_id = 5;

        return view('students.student_class', compact('student', 'classes'));
    }
}
