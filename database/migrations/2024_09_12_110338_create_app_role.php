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
        Schema::create('app_role', function (Blueprint $table) {
            $table->string('role_id', 2)->primary();
            $table->string('role_name', 100)->nullable();
            $table->string('role_description', 100)->nullable();
            $table->string('role_permission', 4)->default('1000')->nullable();
            $table->string('created_by', 15)->nullable();
            $table->string('modified_by', 15)->nullable();
            $table->dateTime('created_date');
            $table->dateTime('updated_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_role');
    }
};
