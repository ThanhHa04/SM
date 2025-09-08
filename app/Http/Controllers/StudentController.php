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
        $latest = StudentProfile::max('id') ?? 0;
        return 'S' . $year . '0' . ($latest + 1);
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
                $user = MainModel::create([
                    'username'   => $params['student_id'],
                    'email'      => $params['email'],
                    'password'   => $params['password'],
                    'role'       => $params['role'],
                ]);
                StudentProfile::create([
                    'user_id'      => $user->id,
                    'name'         => $params['name'],
                    'dob'          => $params['dob'],
                    'email'        => $params['email'],
                    'phone_number' => $params['phone_number'],
                    'student_id'   => $params['student_id'],
                    'gender'       => $params['gender']
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
            $student = StudentProfile::with('user')->findOrFail($id);

            if (!$student) {
                return redirect()->back()->with('error', 'User này chưa có hồ sơ sinh viên');
            }
            $params = $request->all();
            
            if(strlen($params['password']))
                $params['password'] = Hash::make($params['password']);
            else
                unset($params['password']);
            $params['username'] = $params['student_id'];
            $params['role'] = 'student';

            $student->user->update([
                'username'    => $params['student_id'],
                'email'       => $params['email']
            ]);
            $student->update([
                'name'         => $params['name'],
                'dob'          => $params['dob'],
                'phone_number' => $params['phone_number'],
                'gender'       => $params['gender']
            ]);  
            
            return redirect()->route('students')->withSuccess("Đã cập nhật");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function delete($id) {
        try {
            $rec = StudentProfile::with('user')->findOrFail($id);
            $rec->delete();
            return redirect()->back()->withSuccess("Đã xóa");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function showClassroom($id)
    {
        $student = StudentProfile::where('user_id', $id)->firstOrFail();
        $studentt = StudentProfile::with('user', 'classrooms')->findOrFail($student->id);
        $classes = $studentt->classrooms;
            
        // SELECT classrooms.*
        // FROM classrooms
        // JOIN classroom_student
        // ON classroom_student.classroom_id = classrooms.id
        // WHERE classroom_student.student_profile_id = 5;

        return view('students.student_class', compact('student', 'classes'));
    }
}
