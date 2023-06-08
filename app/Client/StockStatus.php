<?php

namespace App\Client;

class StockStatus
{
    public int $price;
    public bool $available;

    public function __construct(int $price, bool $in_stock)
    {
        $this->price = $price;
        $this->available = $in_stock;
    }

}
