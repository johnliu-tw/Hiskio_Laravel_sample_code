<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->make();
        return [
            'id' => $this->faker->randomDigit(),
            'user_id' => $user->id
        ];
    }
}
