<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
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
            'user_id' => \App\Models\User::factory(),
            'title' => $faker->sentence(),
            'content' => $faker->paragraphs(2, true),
            'category' => $faker->randomElement(['Urgent', 'Exam', 'Holiday', 'General']),
        ];
    }
}
