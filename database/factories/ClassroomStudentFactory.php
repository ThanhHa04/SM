<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Classroom;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassroomStudent>
 */
class ClassroomStudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => StudentProfile::inRandomOrder()->first()?->student_id ?? 'S2501',
            'classroom_id' => Classroom::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
