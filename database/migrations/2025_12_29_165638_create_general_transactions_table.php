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
        Schema::create('general_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->text('description')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_transactions');
    }
};
