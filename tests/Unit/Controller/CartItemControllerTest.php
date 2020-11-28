<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase;

    private $fakeUser;
    private $headers = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->fakeUser = User::create(['name'=> 'john',
                                        'email' => 'john@gmail.com',
                                        'password' => 12345678]);
        Passport::actingAs($this->fakeUser);
    }

    /**
     * test create page
     */
    public function testStore()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create(['title' => 'test product',
                                    'content' => 'cool',
                                    'price' => 10,
                                    'quantity' => 20]);
        $res = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id, 'product_id' => $product->id, 'quantity' => 10],
        );
        $res->assertOk();

        $res = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id, 'product_id' => $product->id, 'quantity' => 999],
        );
        $res->assertStatus(400);
    }
}
