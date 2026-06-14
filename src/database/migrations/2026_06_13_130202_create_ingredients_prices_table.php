<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredients_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ingredient_id')
                ->constrained('ingredients')
                ->cascadeOnDelete();

            $table->foreignId('option_size_id')
                ->constrained('option_sizes')
                ->cascadeOnDelete();

            $table->unsignedInteger('price');

            $table->timestamps();

            $table->unique(['ingredient_id', 'option_size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients_prices');
    }
};
