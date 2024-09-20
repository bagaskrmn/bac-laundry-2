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
        Schema::create('app_activity_log', function (Blueprint $table) {
            $table->id();
            $table->text('menu')->nullable();
            $table->text('subject')->nullable();
            $table->string('ip',50)->nullable();
            $table->text('agent')->nullable();
            $table->text('url')->nullable();
            $table->string('method',25)->nullable();
            $table->string('platform',100)->nullable();
            $table->text('description')->nullable();
            $table->string('created_by',15)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_activity_log');
    }
};
