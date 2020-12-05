<?php

namespace Tests\Feature\Controller;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Services\ShortUrlService;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSharedUrl()
    {
        $product = Product::factory()->create();
        $id = $product->id;
        $this->mock(ShortUrlService::class, function ($mock) use ($id) {
            $mock->shouldReceive('makeSortUrl')
                 ->with("http://localhost:3000/products/$id")
                 ->andReturn('fakeUrl');
        });

        $res = $this->call(
            'GET',
            'products/'.$id.'/sharedUrl',
        );
        $res->assertOk();
        $res = json_decode($res->getContent(), true);
        $this->assertEquals($res['url'], 'fakeUrl');
    }
}
