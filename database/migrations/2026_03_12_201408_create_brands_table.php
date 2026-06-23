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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // ex: "Toyota"
            $table->string('symbol');          // ex: "TM" pour Toyota
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('change', 10, 2)->nullable();
            $table->decimal('market_cap', 20, 2)->nullable(); // capitalisation
            $table->timestamp('updated_at')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
