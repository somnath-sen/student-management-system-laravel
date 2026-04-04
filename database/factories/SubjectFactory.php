<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Algorithms', 'Database Systems', 'Mobile Dev', 'AI & ML',
            'Financial Accounting', 'Marketing 101', 'Logistics',
            'Digital Illustrating', '3D Modeling', 'Color Theory',
            'Circuit Analysis', 'Power Systems', 'Microprocessors',
            'Cyber Security', 'Cloud Computing', 'Web Frameworks'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($subjects),
            'course_id' => \App\Models\Course::factory(),
        ];
    }
}
