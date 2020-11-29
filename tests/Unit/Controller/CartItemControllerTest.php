<?php

namespace Tests\Feature\Controller;

use App\Models\CartItem;
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

    public function testUpdate()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create(['title' => 'test product',
                                    'content' => 'cool',
                                    'price' => 10,
                                    'quantity' => 20]);
        $cartItem = $cart->cartItems()->create(['product_id' => $product->id, 'quantity' => 10]);

        $res = $this->call(
            'PUT',
            'cart-items/'.$cartItem->id,
            ['quantity' => 1],
        );
        $this->assertEquals('true', $res->getContent());

        $cartItem->refresh();
        $this->assertEquals(1, $cartItem->quantity);
    }
    public function testDestroy()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create(['title' => 'test product',
                                    'content' => 'cool',
                                    'price' => 10,
                                    'quantity' => 20]);
        $cartItem = $cart->cartItems()->create(['product_id' => $product->id, 'quantity' => 10]);

        $res = $this->call(
            'DELETE',
            'cart-items/'.$cartItem->id,
        );
        $res->assertOk();
        $cartItem = CartItem::find($cartItem->id);

        $this->assertNull($cartItem);
    }
}
