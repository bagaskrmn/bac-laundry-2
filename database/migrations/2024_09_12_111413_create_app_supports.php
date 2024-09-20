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
        Schema::create('app_supports', function (Blueprint $table) {
            $table->id();
            $table->string('key',100);
            $table->text('value')->nullable();
            $table->enum('type', ['base','specific'])->default('base')->nullable();
            $table->string('created_by',15)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->dateTime('updated_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_supports');
    }
};
