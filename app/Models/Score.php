<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_profile_id',
        'class_id',
        'tp1',
        'tp2',
        'qt',
        'ck',
        'tk',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function student() {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }
    
    public $table = "scores";
}
