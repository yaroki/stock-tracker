<?php


namespace App\Client;


use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Target
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get('foo.bar')->json();
        return new StockStatus($results['price'], $results['available']);
    }
}
