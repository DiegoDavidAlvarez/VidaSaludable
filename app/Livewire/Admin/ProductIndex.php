<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;

class ProductIndex extends Component
{
    public function render()
    {
        $categories = Category::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(0);
        $suppliers = Supplier::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(0);
        return view('livewire.admin.product-index', compact('categories', 'suppliers'));
    }
}
