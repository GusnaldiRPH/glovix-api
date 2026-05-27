<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 15, 2); // Harga utama
            $table->decimal('open', 15, 2)->nullable(); // Harga pembukaan
            $table->decimal('high', 15, 2)->nullable(); // Harga tertinggi
            $table->decimal('low', 15, 2)->nullable(); // Harga terendah
            $table->decimal('volume', 20, 2)->nullable(); // Volume trading
            $table->timestamp('price_date'); // Tanggal harga
            $table->timestamps();
            
            // Index untuk query lebih cepat
            $table->index(['asset_id', 'price_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_prices');
    }
};