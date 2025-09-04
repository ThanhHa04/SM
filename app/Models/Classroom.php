<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'teacher_profile_id',
        'subject_id'
    ];

    public function students()
    {
        return $this->belongsToMany(StudentProfile::class, 'classroom_student', 'classroom_id', 'student_profile_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function teacher() {
        return $this->belongsTo(TeacherProfile::class, 'teacher_profile_id');
    }

    public $table = "classes";
}
