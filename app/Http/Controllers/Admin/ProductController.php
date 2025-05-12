<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'bar_code' => 'required|string|unique:products,bar_code',
            'sale_price' => 'required|integer|min:0',
            'purchase_price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
        ]);

        try {
            $validator->validate();

            $product = Product::create([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'description' => $request->description,
                'bar_code' => $request->bar_code,
                'sale_price' => $request->sale_price,
                'purchase_price' => $request->purchase_price,
                'stock' => $request->stock,
                'min_stock' => $request->min_stock,
                'status' => true, // Activo por defecto ✅
            ]);

            return redirect()->route('admin.product.index')
                ->with('success', 'El producto fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
