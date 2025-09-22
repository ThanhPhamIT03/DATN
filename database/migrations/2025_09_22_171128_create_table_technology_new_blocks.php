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
        Schema::create('technology_new_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id');
            $table->foreign('new_id')
                ->references('id')
                ->on('technology_news')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technology_new_blocks');
    }
};
