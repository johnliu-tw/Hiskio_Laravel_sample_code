<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // faker doc: https://github.com/fzaninotto/Faker
        return [
            'id' => $this->faker->randomDigit(),
            'title' => '測試產品',
            'content'   => $this->faker->word,
            'price'  => $this->faker->numberBetween(100, 1000),
            'quantity' => $this->faker->numberBetween(10, 100)
        ];
    }
}
