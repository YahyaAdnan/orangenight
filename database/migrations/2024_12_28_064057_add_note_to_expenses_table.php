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
        Schema::table('expenses', function (Blueprint $table) {
            $table->text('note')->nullable(); // Replace 'existing_column' with the column name after which you want to add 'note'.
        });
    }
    
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
};
