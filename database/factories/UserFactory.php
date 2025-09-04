<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\Classroom;

class UserFactory extends Factory
{
    protected $model = User::class;
    
    private function generateVietnameseName(): string
    {
        $ho = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Vũ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ'];
        $tenDem = ['Văn', 'Thị', 'Hữu', 'Minh', 'Ngọc', 'Quang', 'Anh', 'Thanh'];
        $ten = ['Hòa', 'Tú', 'Hưng', 'Dũng', 'Trang', 'Lan', 'Nhung', 'Khoa', 'Linh', 'Tâm'];

        return $ho[array_rand($ho)] . ' ' .
            $tenDem[array_rand($tenDem)] . ' ' .
            $ten[array_rand($ten)];
    }

    public function definition()
    {
        $roles = ['student', 'teacher'];
        $role = $roles[array_rand($roles)];

        return [
            'name' => $this->generateVietnameseName(),
            'username' => null, // sẽ gán sau
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'role' => $role,
            'profile_id' => null, // sẽ gán sau
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            static $studentIndex = 1;
            static $teacherIndex = 1;
            if ($user->role === 'student') {
                $student_id = 'S250' . $studentIndex++;
                $profile = StudentProfile::create([
                    'student_id' => $student_id,
                    'dob' => $this->faker->dateTimeBetween('2003-01-01', '2006-12-31')->format('Y-m-d'),
                    //'class_id' => Classroom::inRandomOrder()->first()?->id ?? 1,
                    'gender' => $this->faker->randomElement(['Nam', 'Nữ']),
                    'phone_number' => $this->faker->regexify('09[0-9]{8}'),
                ]);
                $user->update([
                    'username' => $student_id,
                    'profile_id' => $profile->id,
                ]);
            } elseif ($user->role === 'teacher') {
                $teacher_id = 'T250' . $teacherIndex++;
                $profile = TeacherProfile::create([
                    'teacher_id' => $teacher_id,
                    'dob' => $this->faker->dateTimeBetween('1990-01-01', '2005-12-31')->format('Y-m-d'),
                    //'phone_number' => $this->faker->phoneNumber(),
                    'phone_number' => $this->faker->regexify('09[0-9]{8}'),
                    'gender' => $this->faker->randomElement(['Nam', 'Nữ']),
                ]);
                $user->update([
                    'username' => $teacher_id,
                    'profile_id' => $profile->id,
                ]);
            }
        });
    }
}
