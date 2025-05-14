<?php

namespace App\Livewire\Admin;

use App\Models\Supplier;
use App\Models\User;
use Livewire\Component;

class PurchaseIndex extends Component
{
    public function render()
    {
        $users = User::all();
        $suppliers = Supplier::all();
        return view('livewire.admin.purchase-index', compact('users', 'suppliers'));
    }
}
