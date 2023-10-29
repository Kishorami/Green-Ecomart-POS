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
        Schema::create('batched_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('item_description');
            $table->string('sku');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);
            $table->double('unit_price');
            $table->double('sell_price');
            // ----------------- extra info--------------------
            $table->string('image')->nullable();
            $table->string('images')->nullable();
            $table->string('name')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('tags')->nullable();
            $table->boolean('show_on_ecommerce')->default(false);
            // ----------------- extra info--------------------
            // ----------------- discount----------------------
            $table->double('discount_price')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            // ----------------- discount----------------------
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batched_items');
    }
};
