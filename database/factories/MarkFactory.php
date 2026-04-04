<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mark>
 */
class MarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'subject_id' => \App\Models\Subject::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
            'marks_obtained' => $this->faker->numberBetween(30, 100),
            'total_marks' => 100,
            'is_locked' => true,
        ];
    }
}
