<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherProfile;
use App\Models\Subject;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_profile_id',
        'subject_id',
    ];

    public function teacherProfile() {
        return $this->belongsTo(TeacherProfile::class, 'teacher_profile_id','id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function classrooms() {
        return $this->hasMany(Classroom::class, 'teacher_profile_id');
    }

    public $table = "teacher_subjects";
}
