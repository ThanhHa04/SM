<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject as MainModel;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherProfile;
use App\Models\TeacherSubject;
class StudentSubjectController extends Controller
{
     public function index()
    {
        $data['rows'] = MainModel::all();
        return view('subjects.index', $data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);
    }
     public function edit($id)
    {
        $data['rec'] = MainModel::findOrFail($id);
        $data['students'] = User::where('role', 'student')->get();
        $data['student_subjects_list'] = TeacherSubject::where('subject_id', $id)->get();
        return view('subjects.form')->with($data);
    }
    
    public function update(Request $request, $id)
    {
        try {
            $rec = MainModel::findOrFail($id);
            $params = $request->all();
            DB::transaction(function () use ($params, $rec) {
                $student_subjects_list = $rec->teacherSubjectList;
                foreach($student_subjects_list as $row)
                    $row->delete();
                $rec->update([
                'name' => $params['name'],
                'code' => $params['code'],
                'credits' => $params['credits'],
                'semester'=> $params['semester'],
            ]);
                if(isset($params['student_id']))
                    foreach($params['student_id'] as $row)
                        TeacherSubject::create(['subject_id' => $rec->id, 'student_id' => $row]);
            });
            return redirect()->route('subjects')->withSuccess("Đã cập nhật");
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }
}
