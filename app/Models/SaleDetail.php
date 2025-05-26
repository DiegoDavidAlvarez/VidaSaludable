<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unitary_price',
    ];

    // Relationship with Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}