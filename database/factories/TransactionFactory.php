<?php

namespace Database\Factories;

use App\Enums\TransactionStatus;
use App\Models\Category;
use App\Models\Customer;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => fake()->numberBetween(100, 1000),
            'due_date' => fake()->dateTimeThisMonth(),
            'vat' => $this->faker->randomDigit(),
            'is_vat_inclusive' => fake()->boolean(),
            'status' => Arr::random(TransactionStatus::cases()),
        ];
    }
}
