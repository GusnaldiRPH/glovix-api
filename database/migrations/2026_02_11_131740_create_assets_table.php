<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Bitcoin, Ethereum, Emas, dll
            $table->string('symbol'); // BTC, ETH, GOLD
            $table->enum('type', ['stock', 'crypto', 'precious_metal']);
            $table->decimal('current_price', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
};