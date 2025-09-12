<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;
use App\Models\TeacherProfile;
use Illuminate\Support\Str;

class ClassroomFactory extends Factory
{
    protected static $index = 0; //Biến chỉ dùng trong class này
    public function definition()
    {
        $subject = Subject::orderBy('id')->skip(self::$index)->first();
        self::$index++;

        $teacher = TeacherProfile::inRandomOrder()->first();
        return [
            'name' => $subject->name . ' (N01)',
            'subject_id' => $subject->id,
            'teacher_profile_id' => $teacher->id,
        ];
    }
}
