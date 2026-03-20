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
        Schema::create('berufe', function (Blueprint $table) {
            $table->increments('id');
            $table->string('beruf');
            $table->unsignedInteger('fragebogen_id')->nullable();
            $table->string('status')->nullable();
            $table->string('ba_beruf')->nullable();
            $table->string('ba_beruf_kurz')->nullable();
            $table->string('maennlich')->nullable();
            $table->string('weiblich')->nullable();
            $table->string('ba_zustand')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berufe');
    }
};
