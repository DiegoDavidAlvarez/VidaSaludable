<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        return view('admin.purchase_detail.index');
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

            $purchaseDetail = PurchaseDetail::create([
                'purchase_id' => $request->purchase_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unitary_cost' => $request->unitary_cost,
            ]);

            return redirect()->route('admin.purchase_detail.index')
                ->with('success', 'El detalle de la  compra fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
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
}
