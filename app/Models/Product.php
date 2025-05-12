<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', // Clave foránea para categoría 📚
        'supplier_id', // Clave foránea para proveedor 🏭
        'name', 
        'description', 
        'bar_code',
        'sale_price', 
        'purchase_price',
        'stock', 
        'min_stock', 
        'status'
    ]; // Campos que podemos llenar al crear/actualizar un producto ✍️

    protected $casts = [
        'status' => 'boolean', // Tratar status como verdadero/falso ✅
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // El producto pertenece a una categoría 📚
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id'); // El producto pertenece a un proveedor 🏭
    }
}
