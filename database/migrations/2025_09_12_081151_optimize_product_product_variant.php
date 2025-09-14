<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('display_price');
            $table->dropColumn('current_price');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('sale_price', 15, 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('display_price', 15, 0);
            $table->decimal('current_price', 15, 0);
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('sale_price');
        });
    }
};
