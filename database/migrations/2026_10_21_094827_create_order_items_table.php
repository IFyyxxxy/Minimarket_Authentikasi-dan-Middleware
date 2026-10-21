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
        Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel orders
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        // Relasi ke tabel products (asumsi kamu sudah punya tabel products)
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->integer('quantity'); // Jumlah beli
        $table->decimal('price', 15, 2); // Harga satuan saat dibeli
        $table->decimal('subtotal', 15, 2); // Harga total per item (qty * price)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
