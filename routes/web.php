<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseDetailController;
use App\Http\Controllers\Admin\SupplierController;
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

Route::prefix('admin')->group(function () {
    Route::resource('categoria', CategoriaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.categoria');
    Route::resource('supplier', SupplierController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.supplier');
    Route::resource('product', ProductController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.product');
    Route::resource('purchase', PurchaseController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase');
    Route::resource('purchase_detail', PurchaseDetailController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.purchase_detail');
});

require __DIR__.'/auth.php';
