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
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Modify the ENUM column by dropping and recreating it
            $table->enum('type', ['move', 'sold', 'import', 'destruction', 'delete'])
                  ->default('move')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Rollback to the original ENUM values
            $table->enum('type', ['move', 'bought', 'import', 'destruction', 'delete'])
                  ->default('move')
                  ->change();
        });
    }
};
