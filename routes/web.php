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
    ->middleware(['auth', 'verified', 'can:dashboard.view'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('categoria', CategoriaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.categoria')
        ->middleware('can:admin.categoria.index');;
    Route::get('categoria/export-pdf', [CategoriaController::class, 'exportPdf'])->name('admin.categoria.export-pdf')
        ->middleware('can:admin.categoria.export-pdf');
    Route::get('categoria/export-excel', [CategoriaController::class, 'exportExcel'])->name('admin.categoria.export-excel')
        ->middleware('can:admin.categoria.export-excel');

    Route::resource('supplier', SupplierController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.supplier')
        ->middleware('can:admin.supplier.index');
    Route::get('supplier/export-pdf', [SupplierController::class, 'exportPdf'])->name('admin.supplier.export-pdf')
        ->middleware('can:admin.supplier.export-pdf');
    Route::get('supplier/export-excel', [SupplierController::class, 'exportExcel'])->name('admin.supplier.export-excel')
        ->middleware('can:admin.supplier.export-excel');

    Route::resource('product', ProductController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.product')
        ->middleware('can:admin.product.index');
    Route::get('product/export-pdf', [ProductController::class, 'exportPdf'])->name('admin.product.export-pdf')
        ->middleware('can:admin.product.export-pdf');
    Route::get('product/export-excel', [ProductController::class, 'exportExcel'])->name('admin.product.export-excel')
        ->middleware('can:admin.product.export-excel');

    Route::resource('purchase', PurchaseController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase')
        ->middleware('can:admin.purchase.index');
    Route::get('purchase/export-pdf', [PurchaseController::class, 'exportPdf'])->name('admin.purchase.export-pdf')
        ->middleware('can:admin.purchase.export-pdf');
    Route::get('purchase/export-excel', [PurchaseController::class, 'exportExcel'])->name('admin.purchase.export-excel')
        ->middleware('can:admin.purchase.export-excel');

    Route::resource('purchase_detail', PurchaseDetailController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase_detail')
        ->middleware('can:admin.purchase_detail.index');
    Route::get('purchase_detail/export-pdf', [PurchaseDetailController::class, 'exportPdf'])->name('admin.purchase_detail.export-pdf')
        ->middleware('can:admin.purchase_detail.export-pdf');
    Route::get('purchase_detail/export-excel', [PurchaseDetailController::class, 'exportExcel'])->name('admin.purchase_detail.export-excel')
        ->middleware('can:admin.purchase_detail.export-excel');

    Route::resource('cliente', ClienteController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.cliente')
        ->middleware('can:admin.cliente.index');
    Route::get('cliente/export-pdf', [ClienteController::class, 'exportPdf'])->name('admin.cliente.export-pdf')
        ->middleware('can:admin.cliente.export-pdf');
    Route::get('cliente/export-excel', [ClienteController::class, 'exportExcel'])->name('admin.cliente.export-excel')
        ->middleware('can:admin.cliente.export-excel');

    Route::resource('sale', SaleController::class)->only(['index', 'store'])->names('admin.sale')
        ->middleware('can:admin.sale.index');
    Route::get('sale/export-pdf', [SaleController::class, 'exportPdf'])->name('admin.sale.export-pdf')
        ->middleware('can:admin.sale.export-pdf');
    Route::get('sale/export-excel', [SaleController::class, 'exportExcel'])->name('admin.sale.export-excel')
        ->middleware('can:admin.sale.export-excel');

    Route::resource('sale_detail', SaleDetailController::class)->only(['index'])->names('admin.sale_detail')
        ->middleware('can:admin.sale_detail.index');
    Route::get('/sale/{id}/download-pdf', [SaleController::class, 'downloadPdf'])->name('sale.download-pdf')
        ->middleware('can:admin.sale_detail.downloadPdf');
    Route::get('/sale/{id}/download-excel', [SaleController::class, 'downloadExcel'])->name('sale.download-excel')
        ->middleware('can:admin.sale_detail.download-excel');
    Route::get('/sale/{id}/print-receipt', [SaleController::class, 'printReceipt'])->name('sale_detail.print-receipt')
        ->middleware('can:admin.sale_detail.print-receipt');
    // Agregar esta ruta a tu archivo routes/web.php dentro del grupo de rutas admin.sale
    // Ruta para consultar DNI
    Route::get('cliente/consultar-dni', [ClienteController::class, 'consultarDni'])->name('admin.cliente.consultar-dni')
        ->middleware('can:admin.cliente.onsultar-dni');
    // Ruta para consultar RUC
    Route::get('/supplier/consultar-ruc', [SupplierController::class, 'consultarRuc'])->name('admin.supplier.consultar-ruc')
        ->middleware('can:admin.cliente.consultar-ruc');
    // Ruta para consultar producto por código
    Route::post('/sale/get-product', [SaleController::class, 'getProduct'])->name('admin.sale.get-product')
        ->middleware('can:admin.sale.get-product');
    // Ruta para consultar cliente por DNI
    Route::post('/sale/get-customer', [SaleController::class, 'getCustomer'])->name('admin.sale.get-customer')
        ->middleware('can:admin.sale.get-customer');
    // Rutas para notificaciones
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead')
        ->middleware('can:admin.notifications.ark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead')
        ->middleware('can:admin.notifications.mark-all-as-read');
});

require __DIR__.'/auth.php';