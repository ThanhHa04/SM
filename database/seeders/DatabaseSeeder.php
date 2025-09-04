<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Score;
use App\Models\StudentSubject;
use App\Models\TeacherSubject;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\TeacherCertificate;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Subject::factory()->count(10)->create();
        Classroom::factory()->count(5)->create();

        User::factory()->count(20)->create([
            'role' => 'student'
        ]);

        User::factory()->count(5)->create([
            'role' => 'teacher'
        ]);

        Score::factory()->count(50)->create();
        StudentSubject::factory()->count(30)->create();
        TeacherSubject::factory()->count(15)->create();

        $students = StudentProfile::all();
        
        $students->each(function ($student) {
            $classroomIds = Classroom::inRandomOrder()->take(rand(2, 5))->pluck('id');
            foreach ($classroomIds as $classroomId) {
                \App\Models\ClassroomStudent::create([
                    'student_profile_id' => $student->id,
                    'classroom_id' => $classroomId
                ]);
            }
        });
    }
}
