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
        Schema::create('app_login', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->string('user_id', 15);
            $table->text('access_token')->nullable();
            $table->enum('status', ['login', 'logout'])->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->dateTime('date')->nullable();
            $table->enum('type', ['api','web'])->nullable();
            
            // foreign
            $table->foreign('user_id')->references('user_id')->on('app_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_login');
    }
};
