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
            $table->increments('id')->notNull();
            $table->string('beruf')->notNull();
            $table->tinyInteger('status')->notNull();
            $table->unsignedInteger('ba_id')->nullable();
            $table->varchar('maennlich', 100)->nullable();
            $table->varchar('weiblich', 100)->nullable();
            $table->char('ba_zustand', 1)->nullable();
            $table->varchar('keywords', 250)->nullable();
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
