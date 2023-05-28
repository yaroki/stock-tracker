<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Facades\App\Client\ClientFactory;

class Retailer extends Model
{
    use HasFactory;

    public function addInStock(Product $product, Stock $stock){
        $stock->product_id = $product->id;
        return $this->stock()->save($stock);
    }

    public function stock(){
        return $this->hasMany(Stock::class);
    }

    public function client(){
        return ClientFactory::make($this);
    }
}
