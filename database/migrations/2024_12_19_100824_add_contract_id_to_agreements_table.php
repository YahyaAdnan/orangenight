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
        Schema::table('agreements', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_id')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->dropColumn('contract_id');
        });
    }
};
