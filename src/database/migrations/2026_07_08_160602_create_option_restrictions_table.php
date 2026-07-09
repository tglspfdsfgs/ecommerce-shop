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
        Schema::create('option_restrictions', function (Blueprint $table) {
            $table->morphs('parent');
            $table->morphs('child');

            $table->timestamps();

            $table->unique([
                'parent_type',
                'parent_id',
                'child_type',
                'child_id',
            ], 'option_restrictions_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_restrictions');
    }
};
