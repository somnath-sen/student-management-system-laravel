<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GamificationStat>
 */
class GamificationStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $xp = $this->faker->numberBetween(100, 5000);
        return [
            'user_id' => \App\Models\User::factory(),
            'total_points' => $xp,
            'level' => floor($xp / 1000) + 1,
            'current_streak' => $this->faker->numberBetween(0, 20),
            'last_login_date' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
