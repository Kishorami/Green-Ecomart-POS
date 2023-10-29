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
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->text('products');
            $table->string('bill_no');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->float('net_price');
            $table->float('paid');
            $table->float('due');
            $table->float('vat_percent');
            $table->float('vat_amount');
            $table->float('points_earned')->default(0);
            $table->float('points_used')->default(0);
            $table->float('points_discount')->default(0);
            $table->float('total_price');
            $table->float('profit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells');
    }
};
