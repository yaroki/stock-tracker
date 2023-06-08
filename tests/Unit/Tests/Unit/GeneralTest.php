<?php

namespace Tests\Unit;

use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{
    use RefreshDatabase;

    public function it_checks_stock_for_products_at_retailers(){
        $this->seed(RetailerWithProducts::class);
        $this->assetFalse(Product::first()->inStock());
    }
}
