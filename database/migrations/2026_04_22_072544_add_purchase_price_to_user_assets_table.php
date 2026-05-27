<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_assets', function (Blueprint $table) {
            if (!Schema::hasColumn('user_assets', 'purchase_price')) {
                $table->decimal('purchase_price', 15, 2)->default(0)->after('quantity');
            }
        });
    }

    public function down()
    {
        Schema::table('user_assets', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
        });
    }
};