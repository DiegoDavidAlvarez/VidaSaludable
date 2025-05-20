<?php

namespace App\Livewire\Admin;

use App\Models\Purchase;
use App\Models\Product;
use Livewire\Component;

class PurchaseDetailIndex extends Component
{
    public function render()
    {
        $purchases = Purchase::all();
        $products = Product::all();
        return view('livewire.admin.purchase-detail-index', compact('purchases', 'products'));
    }
}