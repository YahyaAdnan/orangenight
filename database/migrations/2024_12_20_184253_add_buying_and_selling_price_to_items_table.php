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
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('buying_price', 10, 2)->nullable(); // Nullable if optional
            $table->decimal('selling_price', 10, 2)->nullable(); // Nullable if optional
        });
    }
    
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['buying_price', 'selling_price']);
        });
    }
    
};
