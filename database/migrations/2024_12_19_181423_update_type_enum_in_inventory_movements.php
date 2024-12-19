<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Drop and recreate the ENUM column with new values
            $table->dropColumn('type');
        });

        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->enum('type', ['move', 'sold', 'import', 'destruction', 'delete', 'distribution', 'Delivery', 'refund'])
                  ->default('move');
        });
    }

    public function down()
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Drop the updated ENUM column
            $table->dropColumn('type');
        });

        Schema::table('inventory_movements', function (Blueprint $table) {
            // Recreate the original ENUM column
            $table->enum('type', ['move', 'sold', 'import', 'destruction', 'delete', 'distribution'])
                  ->default('move');
        });
    }
};
