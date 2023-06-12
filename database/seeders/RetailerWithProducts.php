<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetailerWithProducts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::create(['name' => 'Nintendo Switch']);
        $retailer = Retailer::create(['name' => 'Best Buy']);
        $retailer->addInStock($product, new Stock([
            'price' => 200,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => false
        ]));
        User::factory()->create();
    }
}
