<?php

namespace App\Client;

class StockStatus
{
    public $price;
    public bool $available;

    public function __construct($price, bool $in_stock)
    {
        $this->price = $price;
        $this->available = $in_stock;
    }

}
