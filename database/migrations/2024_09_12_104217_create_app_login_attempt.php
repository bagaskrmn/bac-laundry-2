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
        Schema::create('app_login_attempt', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->string('username',50)->nullable();
            $table->string('password',255)->nullable();
            $table->string('ip_address',50)->nullable();
            $table->dateTime('created_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_login_attempt');
    }
};
