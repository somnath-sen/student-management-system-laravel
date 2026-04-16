<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

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
        $faker = Faker::create();

        return [
            'course_id' => \App\Models\Course::factory(),
            'title' => $faker->randomElement(['Annual Tuition', 'Library Fee', 'Lab Charges', 'Exam Fee']),
            'amount' => $faker->numberBetween(500, 5000),
            'due_date' => $faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}
