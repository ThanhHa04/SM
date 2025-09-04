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
        $teacherID = 'T' . $year . '0';
        $count = MainModel::where('role', 'teacher')->orderByDesc('profile_id')->value('profile_id');
        $nextIndex = $count + 1;
        return $teacherID . $nextIndex;
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
                $profile = TeacherProfile::create([
                    'name'         => $params['name'],
                    'phone_number' => $params['phone_number'] ?? null,
                    'email'        => $params['email'],
                    'password'     => $params['password'],
                    'teacher_id'   => $params['teacher_id'],
                    'dob'          => $params['dob'],
                ]);
                $params['profile_id'] = $profile->id;
                MainModel::create([
                    'name'       => $params['name'],
                    'username'   => $params['teacher_id'],
                    'email'      => $params['email'],
                    'password'   => $params['password'],
                    'role'       => $params['role'],
                    'profile_id' => $profile->id,
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
            $rec = MainModel::findOrFail($id);
            $params = $request->all();
            if (strlen($params['password']))
                $params['password'] = Hash::make($params['password']);
            else
                unset($params['password']);
            $params['role'] = 'teacher';
            DB::transaction(function () use ($params, $rec) {
                $rec->profile->update($params);
                $rec->update($params);
                $rec->profile->update([
                    'phone_number' => $params['phone_number'] ?? null,
                ]);
            });
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

