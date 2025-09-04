<?php

namespace Database\Factories;

use App\Models\StudentSubject;
use App\Models\StudentProfile;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentSubjectFactory extends Factory
{
    protected $model = StudentSubject::class;

    public function definition()
    {
        $studentProfile = StudentProfile::inRandomOrder()->first();
        $subject = Subject::inRandomOrder()->first();

        return [
            'student_profile_id' => $studentProfile?->id,
            'subject_id' => $subject?->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
