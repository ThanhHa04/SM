<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected static $index = 0;

    public function definition()
    {
        $subjectNames = [
            'Phân tích dữ liệu',
            'Mạng máy tính',
            'Web nâng cao',
            'C nâng cao',
            'Lập trình hướng đối tượng',
            'Cấu trúc dữ liệu và giải thuật',
            'Cơ sở dữ liệu',
            'Xác suất thống kê',
            'Khoa học trí tuệ nhân tạo',
            'Học máy nâng cao',
        ];

        $index = self::$index++;

        return [
            'name' => $subjectNames[$index] ?? null,
            'code' => fake()->unique()->regexify('[A-Z0-9]{3}'),
            'semester' => fake()->numberBetween(1, 3),
            'credits' => $credits = fake()->numberBetween(2, 4),
            'number_of_lessons' => $credits * 15,
        ];
    }
}
