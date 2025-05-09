<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id', // Debe ser un ID de categoría válido 📚
            'supplier_id' => 'required|exists:suppliers,id', // Debe ser un ID de proveedor válido 🏭
            'name' => 'required|string|max:255', // Nombre del producto es obligatorio ✍️
            'description' => 'nullable|string', // Descripción es opcional 📝
            'bar_code' => 'required|string|unique:products,bar_code', // Código de barras único 📊
            'sale_price' => 'required|numeric|min:0', // Precio de venta debe ser positivo 💰
            'purchase_price' => 'required|numeric|min:0', // Precio de compra debe ser positivo 💸
            'stock' => 'required|integer|min:0', // Stock debe ser un entero no negativo 📦
            'min_stock' => 'required|integer|min:0', // Stock mínimo debe ser no negativo ⚠️
        ]);

        try {
            $validator->validate();

            $product = Product::create([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                // Otros campos...
                'status' => true, // Activo por defecto ✅
            ]);

            return redirect()->route('admin.product.index')
                ->with('success', 'El producto fue registrado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
