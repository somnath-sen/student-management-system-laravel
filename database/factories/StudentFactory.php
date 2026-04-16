<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

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
        $faker = Faker::create();

        return [
            'user_id' => \App\Models\User::factory(),
            'course_id' => \App\Models\Course::factory(),
            'roll_number' => 'STU-' . $faker->unique()->numberBetween(1000, 9999),
            'parent_name' => $faker->name('male'),
            'emergency_phone' => $faker->phoneNumber(),
            'blood_group' => $faker->randomElement(['A+', 'B+', 'O+', 'AB+', 'A-', 'B-', 'O-', 'AB-']),
            'home_address' => $faker->address(),
            'last_lat' => $faker->latitude(),
            'last_lng' => $faker->longitude(),
            'location_updated_at' => now(),
        ];
    }
}
