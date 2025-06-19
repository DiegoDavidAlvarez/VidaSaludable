<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        return view('admin.purchase_detail.index');
    }

    public function getProduct(Request $request)
    {
        $barcode = $request->input('bar_code');
        $product = Product::where('bar_code', $barcode)
            ->where('status', true)
            ->first();

        if ($product) {
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['error' => 'Producto no encontrado o no está activo'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unitary_cost' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            DB::beginTransaction();
            
            $product = Product::where('id', $request->product_id)
                ->where('status', true)
                ->first();

            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => 'Producto no encontrado o inactivo.',
                ]);
            }

            PurchaseDetail::create([
                'purchase_id' => $request->purchase_id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unitary_cost' => $request->unitary_cost,
            ]);

            Product::where('id', $product->id)
                ->increment('stock', $request->quantity);

            DB::commit();

            return redirect()->route('admin.purchase_detail.index')
                ->with('success', 'El detalle de la compra fue registrado correctamente.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar el detalle: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unitary_cost' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            $purchaseDetail = PurchaseDetail::findOrFail($id);
            $purchaseDetail->update([
                'purchase_id' => $request->purchase_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unitary_cost' => $request->unitary_cost,
            ]);

            return redirect()->route('admin.purchase_detail.index')
                ->with('success', 'El detalle de la compra fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        PurchaseDetail::find($id)->delete();
        return redirect()->route('admin.purchase_detail.index')->with('success', 'El detalle de la compra fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $purchaseDetails = PurchaseDetail::with([
            'purchase.supplier',
            'product',
            'purchase.user'
        ])->get();

        $pdf = Pdf::loadView('admin.purchase_detail.pdf', compact('purchaseDetails'));
        return $pdf->download('reporte_detalle_compras.pdf');
    }
}
