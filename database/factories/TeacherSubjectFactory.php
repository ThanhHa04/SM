<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TeacherProfile;
use App\Models\Subject;

class TeacherSubjectFactory extends Factory
{
    public function definition(): array
    {   
        $TeacherProfile = TeacherProfile::inRandomOrder()->first();
        $subject = Subject::inRandomOrder()->first();

        return [
            'teacher_profile_id' => $TeacherProfile->id,
            'subject_id' => $subject?->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
