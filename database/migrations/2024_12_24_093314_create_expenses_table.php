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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Expense title
            $table->enum('category', [
                'Salaries',
                'Importing',
                'Exporting',
                'Logistics',
                'Transportation',
                'Storage',
                'Office Rent',
                'Utilities',
                'Equipment',
                'Marketing',
                'Commissions',
                'Taxes',
                'Insurance',
                'Legal Fees',
                'Miscellaneous',
            ]);
            $table->decimal('amount', 10, 2); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
