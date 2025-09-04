<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'profile_id',
        
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'student_subjects', 'student_id', 'subject_id');
    }

    public function profile() {
        if($this->role == 'student')
            return $this->belongsTo(StudentProfile::class, 'profile_id');
        else if($this->role == 'teacher')
            return $this->belongsTo(TeacherProfile::class, 'profile_id');
        return null;
    }
}
