<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\Condition;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Item::class;

    public function definition()
    {
         return [
            'item_name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 10000),
            'condition_id' => Condition::factory(), // Condition も作成済みの前提
            'user_id' => \App\Models\User::factory(),
            'image' => 'dummy.jpg',
        ];
    }
}
