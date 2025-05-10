<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;

class ProductTable extends Component
{
    public function render()
    {
        $products = Product::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.product-table', compact('products'));
    }
}
