<?php


namespace App\Client;


use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $api_key = config('services.best_buy.key');
        $results = Http::get("https://api.bestbuy.com/v1/products/{$stock->sku}.json?apiKey={$api_key}")->json();
        return new StockStatus(
            (int) ($results['salePrice'] * 100), // dollars to cents
            $results['onlineAvailability']);
    }
}
