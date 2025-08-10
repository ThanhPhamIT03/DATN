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
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->string('email')->nullable()->change();
            $table->string('phone')->unique();
            $table->string('code')->unique();
            $table->json('address')->nullable();
            $table->boolean('promo_register')->nullable();
            $table->date('birthday')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->unique('email');
            $table->dropColumn(['phone', 'code', 'address', 'promo_register', 'birthday']);
        });
    }
};
