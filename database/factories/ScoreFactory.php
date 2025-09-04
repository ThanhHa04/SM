<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Classroom;
use App\Models\StudentProfile;

class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $student_id = StudentProfile::all()->random()->id;
        $class_id = Classroom::all()->random()->id;
        return [
            'student_profile_id' => $student_id,
            'class_id' => $class_id,
            'tp1' => $tp1 = fake()->numberBetween(500, 1000) / 100,
            'tp2' => $tp2 = fake()->numberBetween(500, 1000) / 100,
            'qt' => $qt = fake()->numberBetween(500, 1000) / 100,
            'ck' => $ck = fake()->numberBetween(500, 1000) / 100,
            'tk' => ($tp1+$tp2)*5/100 + $qt*40/100 + $ck*50/100,
        ];
    }
}
