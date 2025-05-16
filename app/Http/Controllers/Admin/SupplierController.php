<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.supplier.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|string|max:11',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        try {
            $validator->validate();
            $supplier = Supplier::create([
                'ruc' => $request->ruc,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'status' => true // Por defecto activo
            ]);

            return redirect()->route('admin.supplier.index')
                ->with('success', 'El proveedor fue registrado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required|string|max:11',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        try {
            $validator->validate();

            $supplier = Supplier::findOrFail($id);
            $supplier->update([
                'ruc' => $request->ruc,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.supplier.index')
                ->with('success', 'El proveedor fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update(['status' => false]);

        return redirect()->route('admin.supplier.index')
            ->with('success', 'El proveedor fue eliminado correctamente.');
    }
}

