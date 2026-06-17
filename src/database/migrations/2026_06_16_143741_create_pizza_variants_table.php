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
        Schema::create('pizza_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pizza_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('option_size_id')
                ->constrained('option_sizes')
                ->cascadeOnDelete();

            $table->foreignId('option_dough_id')
                ->constrained('option_doughs')
                ->cascadeOnDelete();

            $table->foreignId('option_crust_id')
                ->constrained('option_crusts')
                ->cascadeOnDelete();

            $table->unsignedInteger('price');
            $table->unsignedInteger('weight');

            $table->timestamps();

            $table->unique(
                [
                    'pizza_id',
                    'option_size_id',
                    'option_dough_id',
                    'option_crust_id',
                ],
                'pizza_variant_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizza_variants');
    }
};
