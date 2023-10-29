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
        Schema::create('supplier_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->timestamp('date');
            $table->string('particulars');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->double('due_amount')->default(0)->comment('cash to give credit');
            $table->double('payment_amount')->default(0)->comment('cash to giving debit');
            $table->double('total_due')->default(0)->comment('total_due is balance');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_ledgers');
    }
};
