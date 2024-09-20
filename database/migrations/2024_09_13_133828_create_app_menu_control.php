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
        Schema::create('app_menu_control', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('menu_id', 2);
            $table->string('code', 20);
            $table->string('control_name', 100);
            $table->integer('order_no')->nullable();
            $table->foreign('menu_id')->references('menu_id')->on('app_menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_menu_control');
    }
};
