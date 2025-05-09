<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID único para cada producto 🆔
            $table->unsignedBigInteger('category_id'); // Clave foránea para vincular con categorías 📚
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade'); // Vincula con la tabla categories, elimina productos si se borra la categoría 🗑️
            $table->unsignedBigInteger('supplier_id'); // Clave foránea para vincular con proveedores 🏭
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade'); // Vincula con la tabla suppliers, elimina productos si se borra el proveedor 🗑️
            $table->string('name'); // Nombre del producto (por ejemplo, "Smartphone") 📱
            $table->text('description')->nullable(); // Descripción opcional ✍️
            $table->string('codigo_barra')->unique(); // Código de barras único 📊
            $table->decimal('precio_venta', 10, 2); // Precio de venta (por ejemplo, 999.99) 💰
            $table->decimal('precio_compra', 10, 2); // Precio de compra 💸
            $table->integer('stock'); // Cantidad en inventario 📦
            $table->integer('stock_minimo'); // Nivel mínimo de stock ⚠️
            $table->boolean('status')->default(true); // Activo o inactivo ✅
            $table->timestamps(); // Fechas de creación/actualización ⏰
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
