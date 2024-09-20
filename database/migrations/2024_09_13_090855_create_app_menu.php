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
        Schema::create('app_menu', function (Blueprint $table) {
            $table->string('menu_id', 2)->primary();
            $table->string('parent_menu_id', 2)->nullable();
            $table->string('menu_name', 50)->nullable();
            $table->string('menu_description', 100)->nullable();
            $table->string('menu_url', 100)->nullable();
            $table->integer('menu_sort')->nullable();
            $table->string('menu_icon',50)->nullable();
            $table->enum('menu_active', ['1', '0'])->default('1')->nullable();
            $table->enum('menu_display', ['1', '0'])->default('1')->nullable();
            $table->string('created_by', 15)->nullable();
            $table->string('modified_by', 15)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_menu');
    }
};
