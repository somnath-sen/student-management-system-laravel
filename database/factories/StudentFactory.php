<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
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
            'course_id' => \App\Models\Course::factory(),
            'roll_number' => 'STU-' . $this->faker->unique()->numberBetween(1000, 9999),
            'parent_name' => $this->faker->name('male'),
            'emergency_phone' => $this->faker->phoneNumber(),
            'blood_group' => $this->faker->randomElement(['A+', 'B+', 'O+', 'AB+', 'A-', 'B-', 'O-', 'AB-']),
            'home_address' => $this->faker->address(),
            'last_lat' => $this->faker->latitude(),
            'last_lng' => $this->faker->longitude(),
            'location_updated_at' => now(),
        ];
    }
}
