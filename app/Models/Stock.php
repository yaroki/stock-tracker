<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $guarded = [];
    use HasFactory;

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id');
    }
}
