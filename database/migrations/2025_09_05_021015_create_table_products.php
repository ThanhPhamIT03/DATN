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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
            $table->string('name');
            $table->string('slug');
            $table->string('brand');
            $table->string('model');
            $table->text('description');
            $table->string('thumbnail');
            $table->json('images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
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
