<?php

namespace App\Models;

use App\UseCases\TrackStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function track()
    {
        (new TrackStock(Stock::first()))->handle();
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function recordHistory(Stock $stock)
    {
        $this->history()->create([
            'stock_id' => $stock->id,
            'product_id' => $this->id,
            'price' => $stock->price,
            'in_stock' => $stock->in_stock
        ]);
    }
}
