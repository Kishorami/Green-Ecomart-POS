<?php

use App\Models\Configuration;
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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('vat')->default(0);
            $table->string('company_name')->default('Company/Shop Name');
            $table->string('address_line_1')->default('Address Line 1');
            $table->string('address_line_2')->default('Address Line 2');
            $table->string('phone')->default('01xxxxxxxxx');
            $table->string('logo')->default('default_logo.png');
            $table->string('logo_sm')->default('logo-sm.png');
            $table->string('favicon')->default('favicon.png');
            $table->boolean('enable_points')->default(false);
            $table->double('earning_points')->default(0);
            $table->double('per_amount')->default(0);
            $table->double('max_point_per_invoice')->default(0);
            $table->double('money_per_point')->default(0);
            $table->double('min_amount_to_use_points')->default(0);
            $table->double('use_points_per_amount')->default(0);
            $table->timestamps();
        });

        $data = new Configuration();
        $data->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
