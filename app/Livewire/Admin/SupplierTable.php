<?php

namespace App\Livewire\Admin;

use App\Models\Supplier;
use Livewire\Component;

class SupplierTable extends Component
{
    public function render()
    {
        $suppliers = Supplier::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.supplier-table', compact('suppliers'));
    }
}