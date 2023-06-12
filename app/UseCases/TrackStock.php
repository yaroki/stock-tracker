<?php

namespace App\UseCases;

use App\Client\StockStatus;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;

class TrackStock
{
    public Stock $stock;
    public StockStatus $status;

    /**
     * TrackStock constructor.
     * @param  Stock  $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function handle()
    {
        $this->checkAvailability();
        $this->notifyUser();
        $this->updateStock();
        $this->recordToHistory();
    }

    public function checkAvailability()
    {
        $this->status = $this->stock->retailer->client()->checkAvailability($this->stock);
    }

    public function updateStock()
    {
        $this->stock->update(['price' => $this->status->price, 'in_stock' => $this->status->available]);
    }

    public function recordToHistory()
    {
        $this->stock->products->each->recordHistory($this->stock);
    }

    public function notifyUser()
    {
        if ($this->status->available && !$this->stock->in_stock) {
            User::first()->notify(new ImportantStockUpdate($this->stock));
        }
    }
}
