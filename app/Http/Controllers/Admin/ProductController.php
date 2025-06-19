<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
            'description' => 'nullable|string|max:255',
            'bar_code' => 'required|string|unique:products,bar_code|max:255',
            'sale_price' => 'required|numeric|min:0|max:99999999.99',
            'purchase_price' => 'required|numeric|min:0|max:99999999.99',
            'stock' => 'required|integer|min:0|max:99999999999',
            'min_stock' => 'required|integer|min:0|max:99999999999',
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
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'bar_code' => 'required|string|max:255',
            'sale_price' => 'required|numeric|min:0|max:99999999.99',
            'purchase_price' => 'required|numeric|min:0|max:99999999.99',
            'stock' => 'required|integer|min:0|max:99999999999',
            'min_stock' => 'required|integer|min:0|max:99999999999',
        ]);

        try {
            $validator->validate();

            $product = Product::findOrFail($id);
            $product->update([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'description' => $request->description,
                'bar_code' => $request->bar_code,
                'sale_price' => $request->sale_price,
                'purchase_price' => $request->purchase_price,
                'stock' => $request->stock,
                'min_stock' => $request->min_stock,
            ]);

            return redirect()->route('admin.product.index')
                ->with('success', 'El producto fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => false]);

        return redirect()->route('admin.product.index')
            ->with('success', 'El producto fue eliminado correctamente.');
    }
    
    public function exportPdf()
    {
        $products = Product::where('status', true)->get();
        $pdf = Pdf::loadView('Admin.product.pdf', compact('products'));
        return $pdf->download('reporte_productos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'reporte_productos.xlsx');
    }
}