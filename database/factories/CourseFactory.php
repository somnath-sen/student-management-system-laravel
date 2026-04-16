<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();

        $courses = [
            'B.Sc Computer Science',
            'Business Administration',
            'Graphic Design & Animation',
            'Electrical Engineering',
            'Modern Literature',
            'Mechanical Engineering',
            'Civil Engineering',
            'Data Science & AI',
            'Nursing & Health Sciences',
            'Psychology',
        ];

        return [
            // Use $this->faker instead of the modern fake() helper for compatibility
            'name' => $faker->unique()->randomElement($courses),
            'description' => $faker->paragraph(),
            'admit_cards_published' => $faker->boolean(70),
        ];
    }
}