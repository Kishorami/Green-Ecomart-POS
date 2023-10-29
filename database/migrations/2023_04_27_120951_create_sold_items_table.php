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
        Schema::create('sold_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sell_id')->constrained('sells')->onDelete('cascade');
            $table->foreignId('batched_item_id')->constrained('batched_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->float('sell_price');
            $table->float('profit');
            $table->enum('sold_from',['pos','ecommerce'])->default('pos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sold_items');
    }
};
