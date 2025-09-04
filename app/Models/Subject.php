<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'credits',
        'semester',
    ];

    public function teacherSubjectList() {
        return $this->hasMany(TeacherSubject::class, 'subject_id');
    }
   public function students() {
      return $this->belongsToMany(Student::class, 'student_subject');
    }
    public function classrooms() {
      return $this->hasMany(Classroom::class, 'subject_id');
    }
    public function studentSubjects() { 
      return $this->hasMany(StudentSubject::class, 'subject_id');
    } 
    
    public $table = "subjects";
}
