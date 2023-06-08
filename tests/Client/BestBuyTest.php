<?php

namespace Tests\Client;

use App\Client\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;


class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_tracks_product(){
        $this->seed(RetailerWithProducts::class);
        $product = tap(Stock::first())->update(['sku' => '6540265', 'url' => 'https://www.bestbuy.com/site/nintendo-switch-oled-console-the-legend-of-zelda-tears-of-the-kingdom-edition/6540265.p?skuId=6540265']);
        try{
            $product->track();
        }catch (\Exception $exception){
            $this->fail('BestBuy API fails: ' . $exception->getMessage());
        }
        $this->assertTrue(true);
    }

    /** @test **/
    public function it_creates_right_response(){
        Http::fake(fn() => ['onlineAvailability' => true, 'salePrice' => '99.99']);
        $result = (new BestBuy)->checkAvailability(new Stock);
        $this->assertEquals(9999, $result->price);
        $this->assertEquals(true, $result->available);
    }
}
