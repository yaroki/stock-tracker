<?php

namespace App\Client;

use App\Models\Stock;

interface Client
{
   public function checkAvailability(Stock $stock);
}
