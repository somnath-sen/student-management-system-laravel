<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
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
            'phone' => $faker->phoneNumber(),
            'qualification' => $faker->randomElement(['Ph.D', 'M.Sc', 'M.Tech', 'MBA']),
            'experience' => $faker->numberBetween(2, 20) . ' Years',
        ];
    }
}
