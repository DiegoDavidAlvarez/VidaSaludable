<?php

namespace App\Livewire\Admin;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use Livewire\Component;

class PurchaseTable extends Component
{
    public function render()
    {
        $users = User::all();
        $suppliers = Supplier::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $purchases = Purchase::where('id', '!=', null)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.purchase-table', compact('users', 'suppliers', 'purchases'));
    }
}
