<?php

namespace App\Livewire\Admin;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use Livewire\Component;

class PurchaseDetailTable extends Component
{
    public function render()
    {
        $purchaseDetails = PurchaseDetail::orderBy('created_at', 'desc')
            ->paginate(10);
        $purchases = Purchase::all();
        $products = Product::all();
        return view('livewire.admin.purchase-detail-table', compact('purchaseDetails', 'purchases', 'products'));
    }
}