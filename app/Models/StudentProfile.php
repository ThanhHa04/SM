<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'dob',
        'student_id',
        'phone_number',
        'gender'
    ];

    public function user() {
        return $this->hasOne(User::class, 'profile_id')->where('role', 'student');  //users.profile_id = student_profiles.id
    }
    public function subjects() {
    
        return $this->belongsToMany(Subject::class, 'student_subject');
        // student_profiles.id
        //     ↓
        // student_subject.student_profile_id = student_profiles.id
        //     ↔
        // student_subject.subject_id
        //     ↓
        // subjects.id = subject_id 
    }

    public function studentSubjects() 
    {
        return $this->hasMany(StudentSubject::class, 'student_profile_id'); //student_subjects.student_profile_id = student_profiles.id
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_student', 'student_profile_id', 'classroom_id');
    }

    public $table = "student_profiles";
}
