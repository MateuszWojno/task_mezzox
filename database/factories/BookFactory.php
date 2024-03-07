<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['av', 'unav']);
        $borrowerId = $status === 'unav' ? Customer::inRandomOrder()->first()->id : null;

        return [
            'title'            => fake()->title,
            'author'           => fake()->name,
            'publication_year' => fake()->date(1900, date('Y')),
            'publisher'        => fake()->name,
            'status'           => $status,
            'borrower_id'      => $borrowerId,
        ];
    }
}
