<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    // OrderItem ini milik siapa (Order)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // OrderItem ini produknya apa (Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}