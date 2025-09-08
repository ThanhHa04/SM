<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User as MainModel;
use App\Models\TeacherProfile;
use App\Models\TeacherSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Classroom;

class TeacherController extends Controller
{
    public function index()
    {
        $data['rows'] = MainModel::where('role', 'teacher')->get();
        return view('teachers.index', $data);
    }

    private function generateTeacherId(): string
    {
        $year = date('y');
        $latest = TeacherProfile::max('id') ?? 0;
        return 'T' . $year . '0' . ($latest + 1);
    }

    public function add()
    {   
        $data['teacher_id'] = $this->generateTeacherId();
        return view('teachers.form', $data);
    }

    public function create(Request $request){
        try {
            $params = $request->all();
            $params['password'] = Hash::make($params['password']);
            $params['role'] = 'teacher';
            DB::transaction(function () use ($params) {
                $user = MainModel::create([
                    'username'   => $params['teacher_id'],
                    'email'      => $params['email'],
                    'password'   => $params['password'],
                    'role'       => $params['role'],
                ]);
                TeacherProfile::create([
                    'name'         => $params['name'],
                    'phone_number' => $params['phone_number'] ?? null,
                    'email'        => $params['email'],
                    'password'     => $params['password'],
                    'teacher_id'   => $params['teacher_id'],
                    'dob'          => $params['dob'],
                    'gender'       => $params['gender'],
                    'user_id'      => $user->id,
                ]);
                
            });
            return redirect()->route('teachers')->withSuccess("Đã thêm");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data['rec'] = MainModel::findOrFail($id);
        return view('teachers.form')->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $teacher = TeacherProfile::with('user')->findOrFail($id);
            if (!$teacher) {
                return redirect()->back()->with('error', 'User này chưa có hồ sơ sinh viên');
            }
            $params = $request->all();
            if (strlen($params['password']))
                $params['password'] = Hash::make($params['password']);
            else
                unset($params['password']);
            $params['role'] = 'teacher';
            $teacher->user->update([
                'username'   => $params['teacher_id'],
                'email'      => $params['email'],
            ]);
            $teacher->update([
                'name'         => $params['name'],
                'phone_number' => $params['phone_number'],  
                'dob'          => $params['dob'],
                'gender'       => $params['gender']
            ]);
            return redirect()->route('teachers')->withSuccess("Đã cập nhật");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $rec->profile->delete();
            $rec->delete();
            return redirect()->back()->withSuccess("Đã xóa");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function showInfo($id){
        $teacherProfile = TeacherProfile::with('user')->findOrFail($id);
        $teacherSubjects = TeacherSubject::with('subject')->where('teacher_profile_id', $id)->get();
        $classroom_list = Classroom::where('teacher_profile_id', $id)->get();

        return view('teachers.teacher_info', compact('teacherProfile', 'teacherSubjects', 'classroom_list'));
    }


}

