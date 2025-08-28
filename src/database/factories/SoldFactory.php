<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sold;
use App\Models\User;
use App\Models\Item;

class SoldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Sold::class;

    public function definition()
    {
        $payments = ['カード払い', 'コンビニ払い'];
         return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment' => $this->faker->randomElement($payments),
            'destination_postcode' => $this->faker->postcode(),
            'destination_address' => $this->faker->address(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
