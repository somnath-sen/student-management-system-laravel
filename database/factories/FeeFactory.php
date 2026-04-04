<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => \App\Models\Course::factory(),
            'title' => $this->faker->randomElement(['Annual Tuition', 'Library Fee', 'Lab Charges', 'Exam Fee']),
            'amount' => $this->faker->numberBetween(500, 5000),
            'due_date' => $this->faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}
