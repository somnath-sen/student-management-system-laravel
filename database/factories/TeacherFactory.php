<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'user_id' => \App\Models\User::factory(),
            'phone' => $this->faker->phoneNumber(),
            'qualification' => $this->faker->randomElement(['Ph.D', 'M.Sc', 'M.Tech', 'MBA']),
            'experience' => $this->faker->numberBetween(2, 20) . ' Years',
        ];
    }
}
