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
        static $index = 0;

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

        // Ensure unique selection simply by iterating
        $name = $courses[$index];
        $index = ($index + 1) % count($courses);

        return [
            'name' => $name,
            'description' => 'A rigorous academic curriculum focusing on advanced topics in ' . $name . '.',
            'admit_cards_published' => rand(1, 100) <= 70, // 70% chance of true
        ];
    }
}