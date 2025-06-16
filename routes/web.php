<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseDetailController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SaleDetailController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\NotificationController;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
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
    Route::get('categoria/export-pdf', [CategoriaController::class, 'exportPdf'])->name('admin.categoria.export-pdf');
    Route::resource('supplier', SupplierController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.supplier');
    Route::get('supplier/export-pdf', [SupplierController::class, 'exportPdf'])->name('admin.supplier.export-pdf');
    Route::resource('product', ProductController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.product');
    Route::resource('purchase', PurchaseController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase');
    Route::resource('purchase_detail', PurchaseDetailController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase_detail');
    Route::resource('cliente', ClienteController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.cliente');
    Route::resource('sale', SaleController::class)->only(['index', 'store'])->names('admin.sale');
    Route::resource('sale_detail', SaleDetailController::class)->only(['index'])->names('admin.sale_detail');
    // Ruta para consultar DNI
    Route::get('cliente/consultar-dni', [ClienteController::class, 'consultarDni'])->name('admin.cliente.consultar-dni');
    // Ruta para consultar RUC
    Route::get('/supplier/consultar-ruc', [SupplierController::class, 'consultarRuc'])->name('admin.supplier.consultar-ruc');
    // Ruta para consultar producto por código
    Route::post('/sale/get-product', [SaleController::class, 'getProduct'])->name('admin.sale.get-product');
    // Ruta para consultar cliente por DNI
    Route::post('/sale/get-customer', [SaleController::class, 'getCustomer'])->name('admin.sale.get-customer');
    // Rutas para notificaciones
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
});

require __DIR__.'/auth.php';