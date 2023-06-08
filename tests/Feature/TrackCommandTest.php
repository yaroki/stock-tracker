<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_tracks_product_stock(): void
    {
        $this->seed(RetailerWithProducts::class);
        $product = Product::first();
        $this->assertFalse($product->inStock());

        Http::fake(fn () => ['onlineAvailability' => true, 'salePrice' => 1000]);
        $this->artisan('track');
        $this->assertTrue($product->inStock());
    }
}
