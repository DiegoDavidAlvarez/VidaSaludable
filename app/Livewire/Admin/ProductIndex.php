<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;

class ProductIndex extends Component
{
    public function render()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('livewire.admin.product-index', compact('categories', 'suppliers'));
    }
}
