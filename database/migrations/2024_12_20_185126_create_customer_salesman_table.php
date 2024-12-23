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
        Schema::create('customer_salesman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Foreign key to customers table
            $table->foreignId('salesman_id')->constrained()->onDelete('cascade'); // Foreign key to salesmen table
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('customer_salesman');
    }
    
};
