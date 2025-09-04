<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    use HasFactory;

    protected $table = 'student_subjects';

    protected $fillable = [
        'student_id',
        'subject_id',
        'number_of_lessons',
    ];

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }
 
    public function subjects()
   {
     return $this->belongsToMany(Subject::class, 'student_subjects', 'student_id', 'id');
   }
}
