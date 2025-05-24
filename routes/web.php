<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\Compra_detalleController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseDetailController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\Venta_detalleController;
use App\Http\Controllers\Admin\VentaController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('categoria', CategoriaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.categoria');
    Route::resource('supplier', SupplierController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.supplier');
    Route::resource('product', ProductController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.product');
    Route::resource('purchase', PurchaseController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase');
    Route::resource('purchase_detail', PurchaseDetailController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase_detail');
    Route::resource('cliente', ClienteController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.cliente');
    // Route::resource('venta', VentaController::class)->only(['index', 'store'])->names('admin.venta');
    // Route::resource('venta_detalle', Venta_detalleController::class)->only(['index'])->names('admin.venta_detalle');
    // Ruta para consultar DNI
    Route::get('cliente/consultar-dni', [ClienteController::class, 'consultarDni'])->name('admin.cliente.consultar-dni');
    // Ruta para consultar RUC
    Route::get('supplier/consultar-ruc', [SupplierController::class, 'consultarRuc'])->name('admin.supplier.consultar-ruc');
    // // Ruta para consultar producto por codigo
    // Route::post('/admin/venta/get-product', [VentaController::class, 'getProduct'])->name('admin.venta.get-product');
    // // Ruta para consultar cliente por dni
    // Route::post('/admin/venta/get-customer', [VentaController::class, 'getCustomer'])->name('admin.venta.get-customer');
});

require __DIR__.'/auth.php';