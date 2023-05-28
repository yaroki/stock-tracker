<?php

namespace App\Client;

use App\Models\Retailer;
use Illuminate\Support\Str;

class ClientFactory
{
    public function make(Retailer $retailer)
    {
        $retailer_class = "App\\Client\\".Str::studly($retailer->name);
        if (!class_exists($retailer_class)) {
            throw new \Exception('No Client Class');
        }
        return new $retailer_class;
    }
}
