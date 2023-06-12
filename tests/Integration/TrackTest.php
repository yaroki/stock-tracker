<?php

namespace Tests\Integration;

use App\Models\History;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use App\UseCases\TrackStock;
use Database\Seeders\RetailerWithProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RetailerWithProducts::class);
        Notification::fake();
        Http::fake(fn () => ['onlineAvailability' => true, 'salePrice' => 249]);
        (new TrackStock(Stock::first()))->handle();
    }

    /** @test */

    public function it_updates_the_stock()
    {
        $stock = Stock::first();
        $this->assertEquals(24900, $stock->price);
        $this->assertTrue($stock->in_stock);
    }

    /** @test */

    public function it_notifies_a_user()
    {
        Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
    }

    /** @test */

    public function it_records_to_history()
    {
        $this->assertEquals(1, History::count());
    }
}
