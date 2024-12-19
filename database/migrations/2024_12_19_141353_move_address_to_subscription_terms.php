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
        // Drop 'address' column from the 'subscriptions' table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('address');
        });

        // Add 'address' column to the 'subscription_terms' table
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $table->string('address')->nullable();  // You can adjust the type and nullability as needed
        });
    }

    public function down()
    {
        // Revert the 'address' column back to 'subscriptions' table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('address')->nullable();  // Adjust this if needed
        });

        // Remove 'address' column from the 'subscription_terms' table
        Schema::table('customer_subscriptions', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
};
