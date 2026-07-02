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
        Schema::create('ingredient_category_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('ingredients_categories')
                ->cascadeOnDelete();

            $table->foreignId('size_id')
                ->constrained('option_sizes')
                ->cascadeOnDelete();

            $table->unsignedInteger('price');

            $table->timestamps();

            $table->unique(['category_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_category_prices');
    }
};
