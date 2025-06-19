<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PurchasesExport;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('admin.purchase.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'receipt_type' => 'required|string',
        ]);

        try {
            $validator->validate();
            /**@disregard*/
            $purchase = Purchase::create([
                'user_id' => auth()->user()->id,
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
                'total' => $request->total,
                'receipt_type' => $request->receipt_type,
            ]);

            return redirect()->route('admin.purchase.index')
                ->with('success', 'La compra fue registrada correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'receipt_type' => 'required|string',
        ]);

        try {
            $validator->validate();

            $purchase = Purchase::findOrFail($id);
            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
                'total' => $request->total,
                'receipt_type' => $request->receipt_type,
            ]);

            return redirect()->route('admin.purchase.index')
                ->with('success', 'La compra fue actualizada correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $purchase = Purchase::find($id)->delete();
        return redirect()->route('admin.purchase.index')
            ->with('success', 'La compra fue eliminada correctamente.');
    }

    public function exportPdf()
    {
        $purchases = Purchase::all();
        $pdf = Pdf::loadView('admin.purchase.pdf', compact('purchases'));
        return $pdf->download('reporte_compras.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PurchasesExport, 'reporte_compras.xlsx');
    }
}
