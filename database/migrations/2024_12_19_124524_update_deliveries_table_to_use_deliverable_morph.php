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
        Schema::table('deliveries', function (Blueprint $table) {
            // Drop the old foreign key column if it exists
            $table->dropForeign(['customer_subscription_id']);  // Drop foreign key if it exists
            $table->dropColumn('customer_subscription_id');     // Drop the column if it exists

            // Add the polymorphic 'deliverable' column
            $table->morphs('deliverable');  // Creates 'deliverable_id' and 'deliverable_type'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            // Drop the polymorphic columns
            $table->dropMorphs('deliverable');
            
            // Optionally, revert to the previous foreign key column
            $table->foreignId('customer_subscription_id')->constrained()->cascadeOnDelete();
        });
    }
};
