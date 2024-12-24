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
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('salesman_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('salesman_id')->references('id')->on('sales_men')->onDelete('cascade');
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('customer_salesman');
    }
    
};
