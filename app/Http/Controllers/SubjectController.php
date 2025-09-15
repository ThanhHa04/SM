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
        $user = auth()->user();

        if (!empty($user->teacher_id)) {
            $subjectIds = TeacherSubject::where('teacher_profile_id', $user->teacher_id)
                ->pluck('subject_id');
            $rows = MainModel::whereIn('id', $subjectIds)->get();
        } else {
            $rows = MainModel::all();
        }

        return view('subjects.index', [
            'rows' => $rows,
            'totalSubject' => $rows->count(),
            'enableSearch' => true,
            'searchRoute' => route('subjects.search'),
        ]);
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
        $request->validate([
            'name' => 'required|string|unique:subjects,name',
            'code' => 'required|string|unique:subjects,code',
        ], [
            'name.unique' => 'Tên môn học này đã tồn tại',
            'code.unique' => 'Mã môn học này đã tồn tại.',
        ]);
        
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
        $data['teachers'] = TeacherProfile::get();
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

    public function teachers($subjectId)
    {
        $teacherIds = TeacherSubject::where('subject_id', $subjectId)
            ->pluck('teacher_profile_id');

        $teachers = TeacherProfile::whereIn('id', $teacherIds)->get();
        return response()->json($teachers);
    }


}
