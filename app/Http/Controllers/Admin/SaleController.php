<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\Notifications\LowStockNotification;

class SaleController extends Controller
{
    public function index()
    {
        return view('admin.sale.index');
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

    public function getCustomer(Request $request)
    {
        $numeroDocumento = $request->input('numero_documento');
        $customer = Customer::select('id', 'nombres', 'apellidos')
            ->where('numero_documento', $numeroDocumento)
            ->first();

        if ($customer) {
            return response()->json([
                'id' => $customer->id,
                'nombres' => $customer->nombres,
                'apellidos' => $customer->apellidos,
            ]);
        } else {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        // ... (código previo para validación y creación de venta)

        $productsToUpdate = [];
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $saleDetailsData[] = [
                // ... (datos de detalles de venta)
            ];
            $productsToUpdate[$product->id] = [
                'quantity' => $item['quantity'],
                'product' => $product,
            ];
        }

        SaleDetail::insert($saleDetailsData);

        foreach ($productsToUpdate as $productId => $data) {
            $product = $data['product'];
            $quantity = $data['quantity'];
            Product::where('id', $productId)->decrement('stock', $quantity);
            $product->refresh();
            if ($product->stock <= $product->min_stock) {
                Auth::user()->notify(new LowStockNotification($product));
            }
        }

        // ... (confirmar transacción y respuesta)
    }

}