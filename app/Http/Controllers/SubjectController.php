<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject as MainModel;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherProfile;
use App\Models\TeacherSubject;
use App\Models\User;
use App\Models\Classroom;

class SubjectController extends Controller
{
    public function index()
    {
        $data['rows'] = MainModel::all();
        $data['totalSubject'] = MainModel::count();
        $data['enableSearch'] = true;
        $data['searchRoute'] = route('subjects.search');
        return view('subjects.index', $data);
    }

    public function search(Request $request)
    {
        $query = MainModel::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', "%$keyword%")
                  ->orWhere('code', 'like', "%$keyword%");
        }

        $data['rows'] = $query->get();
        $data['totalSubject'] = $query->count();
        $data['enableSearch'] = true;

        return view('subjects.index')->with($data);
    }
    
    public function add()
    {
        $data['teachers'] = TeacherProfile::with('user')->get();
        return view('subjects.form', $data);
    }

    public function create(Request $request)
    {
        try {
            $params = $request->all();
            DB::transaction(function () use ($params) {
                $rec = MainModel::create([
                'name' => $params['name'],
                'code' => $params['code'],
                'credits' => $params['credits'],
                'semester'=> $params['semester'],
            ]);
                if(isset($params['teacher_profile_id']))
                    foreach($params['teacher_profile_id'] as $row)
                        TeacherSubject::create(['subject_id' => $rec->id, 'teacher_profile_id' => $row]);
            });
            return redirect()->route('subjects')->withSuccess("Đã thêm");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data['rec'] = MainModel::findOrFail($id);
        $data['teachers'] = User::where('role', 'teacher')->get();
        $data['teacher_subject_list'] = TeacherSubject::where('subject_id', $id)->get();
        return view('subjects.form')->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $params = $request->all();
            DB::transaction(function () use ($params, $rec) {
                $teacher_subject_list = $rec->teacherSubjectList;
                foreach($teacher_subject_list as $row)
                    $row->delete();
                    $rec->update([
                    'name' => $params['name'],
                    'code' => $params['code'],
                    'credits' => $params['credits'],
                    'semester'=> $params['semester'],
                    
                ]);
                if(isset($params['teacher_profile_id']))
                    foreach($params['teacher_profile_id'] as $row)
                        TeacherSubject::create(['subject_id' => $rec->id, 'teacher_profile_id' => $row]);
            });
            return redirect()->route('subjects')->withSuccess("Đã cập nhật");
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

    public function showSubject($id){
        $subject = MainModel::findOrFail($id);

        $teacher_subject_list = TeacherSubject::with('teacherProfile.user')
            ->where('subject_id', $id)
            ->get()
            ->unique('teacher_profile_id');

        $classroom_list = Classroom::where('subject_id', $id)->get();
        
        return view('subjects.subject_info', compact('subject', 'teacher_subject_list', 'classroom_list'));
    }

    public function getTeachersBySubject($id)
    {
        // Lấy tất cả teacher_profile_id trong bảng teacher_subjects
        $teacherIds = TeacherSubject::where('subject_id', $id)->pluck('teacher_profile_id');

        // Lấy thông tin giáo viên
        $teachers = TeacherProfile::whereIn('id', $teacherIds)->get();

        // Trả về JSON
        return response()->json($teachers);
    }

}
