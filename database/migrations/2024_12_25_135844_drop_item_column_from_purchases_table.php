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
        // Drop the 'item' column from the 'purchases' table
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('items');
        });
    }

    public function down()
    {
        // Recreate the 'item' column if rolling back the migration
        Schema::table('purchases', function (Blueprint $table) {
            $table->json('items')->nullable();  // Adjust the column type if needed
        });
    }
};
