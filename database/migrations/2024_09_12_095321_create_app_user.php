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
        Schema::create('app_user', function (Blueprint $table) {
            $table->string('user_id', 15)->primary();
            $table->text('user_full_name')->nullable();
            $table->string('username', 50);
            $table->string('user_email', 50)->nullable();
            $table->string('user_password', 255);
            $table->enum('user_active', ['1','0'])->default('1');
            $table->integer('employee_id')->nullable();
            $table->string('user_img_path', 100)->nullable();
            $table->string('user_img_name', 200)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->string('created_by', 15)->nullable();
            $table->string('modified_by', 15)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('modified_date')->nullable();
            $table->string('device_token', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_user');
    }
};
