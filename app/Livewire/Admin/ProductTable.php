<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class ProductTable extends Component
{
    public function render()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $products = Product::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.product-table', compact('products', 'categories', 'suppliers'));
    }
}
