<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;

class SaleTable extends Component
{
    public function render()
    {
        $sales = Sale::orderBy('created_at', 'desc')->paginate(10);;
        return view('livewire.admin.sale-table',compact('sales'));
    }
}