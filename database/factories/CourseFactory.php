<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            // Use the modern fake() helper instead of $this->faker
            'name' => fake()->unique()->randomElement($courses),
            'description' => fake()->paragraph(),
            'admit_cards_published' => fake()->boolean(70),
        ];
    }
}