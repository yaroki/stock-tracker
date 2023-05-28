<?php

namespace App\Client;

use App\Models\Stock;

interface Target
{
   public function checkAvailability(Stock $stock);
}
