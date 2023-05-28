<?php

namespace Tests\Unit;

use App\Models\Product;
use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->seed(RetailerWithProducts::class);
        $this->assertTrue(Product::first()->inStock());
    }
}
