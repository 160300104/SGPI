<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'loan_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
                // 'id_lab' => $this->faker->randomElements(['1','2','3','5']),
                'id_lab' => $this->faker->numberBetween(1, 5),
                'id_user' => $this->faker->numberBetween(1, 3),
                'id_status' => $this->faker->numberBetween(1, 2)
        ];
    }
}
