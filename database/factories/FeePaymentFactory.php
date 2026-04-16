<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeePayment>
 */
class FeePaymentFactory extends Factory
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
            'user_id' => \App\Models\User::factory()->student(),
            'fee_id' => \App\Models\Fee::factory(),
            'amount_paid' => function (array $attributes) {
                return \App\Models\Fee::find($attributes['fee_id'])->amount;
            },
            'payment_method' => $faker->randomElement(['Card', 'Cash', 'UPI', 'Bank Transfer']),
            'transaction_id' => $faker->unique()->bothify('TXN-#####-?????'),
            'status' => 'Paid',
        ];
    }
}
