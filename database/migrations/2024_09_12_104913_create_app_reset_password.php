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
        Schema::create('app_reset_password', function (Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->string('user_id',15);
            $table->string('ip_address',100)->nullable();
            $table->text('token')->nullable();
            $table->enum('status', ['0','1'])->default('1')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('max_age');
            $table->dateTime('updated_date');

            $table->foreign('user_id')->references('user_id')->on('app_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_reset_password');
    }
};
