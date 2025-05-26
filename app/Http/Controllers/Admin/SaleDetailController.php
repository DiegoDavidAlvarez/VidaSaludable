<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{
    public function index()
    {
        return view('admin.sale_detail.index');
    }
}