<?php

namespace App\Models;

use App\Events\NowInStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $guarded = [];
    use HasFactory;

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->hasMany(Retailer::class);
    }

    public function track($callback = null)
    {
        $result = $this->retailer->client()->checkAvailability($this);
        if ($result->available && !$this->in_stock) {
            event(new NowInStock($this));
        }
        $this->update(['price' => $result->price, 'in_stock' => $result->available]);
        $callback && $callback($this);
    }
}
