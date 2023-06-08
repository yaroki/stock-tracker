<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Stock;
use App\Models\History;
use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_creates_history_as_tracked(): void
    {
        $this->seed(RetailerWithProducts::class);
        $product = Product::first();
        $this->assertCount(0, $product->history);

        Http::fake(fn () => ['onlineAvailability' => true, 'salePrice' => 99]);
        $product->track();

        $this->assertCount(1, $product->refresh()->history);
        $history = $product->history->first();
        $stock = $product->stock->first();

        $this->assertEquals($history->price, 9900);
        $this->assertEquals($history->in_stock, true);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);
    }
}
