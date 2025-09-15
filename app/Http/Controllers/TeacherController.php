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
        $data['rows'] = TeacherProfile::with('user')->get();
        $data['totalTeacher'] = TeacherProfile::count();
        $data['enableSearch'] = true;
        $data['searchRoute'] = route('teachers.search');
        return view('teachers.index', $data);
    }

public function search(Request $request)
    {
        $query = TeacherProfile::with('user');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
            })->orWhere('teacher_id', 'like', "%$keyword%");
        }

        $data['rows'] = $query->get();
        $data['totalTeacher'] = $query->count();
        $data['enableSearch'] = true;

        return view('teachers.index')->with($data);
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

            if (MainModel::where('email', $params['email'])->exists()) {
                return redirect()->back()
                    ->withError("Email này đã được sử dụng")
                    ->withInput();
            }
            
            $params['password'] = Hash::make($params['password']);
            $data['teacher_id'] = $this->generateTeacherId();
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
        $data['classes'] = Classroom::all();
        $data['rec'] = TeacherProfile::with('user')->findOrFail($id);
        return view('teachers.form')->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $student = StudentProfile::with('user')->findOrFail($id);

            if (!$student) {
                return redirect()->back()->with('error', 'User này chưa có hồ sơ giảng viên');
            }
            $params = $request->all();
            
            if(strlen($params['password']))
                $params['password'] = Hash::make($params['password']);
            else
                unset($params['password']);
            $params['username'] = $params['teacher_id'];
            $params['role'] = 'teacher';

            $student->user->update([
                'username'    => $params['teacher_id'],
                'email'       => $params['email']
            ]);
            $student->update([
                'name'         => $params['name'],
                'dob'          => $params['dob'],
                'phone_number' => $params['phone_number'],
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

