<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RetailerWithProducts::class);
        Notification::fake();
    }

    /** @test */

    public function it_tracks_product_stock(): void
    {
        $product = Product::first();
        $this->assertFalse($product->inStock());

        Http::fake(fn () => ['onlineAvailability' => true, 'salePrice' => 1000]);
        $this->artisan('track');
        $this->assertTrue($product->inStock());
    }

    /** @test */

    public function it_notifies_the_user_that_item_not_in_stock(): void
    {
        Http::fake(fn () => ['onlineAvailability' => false, 'salePrice' => 1000]);
        $this->artisan('track');
        Notification::assertNothingSent();
    }
}
