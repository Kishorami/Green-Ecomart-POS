<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('user_type')->default('cashier');
            $table->string('contact')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        $data = new User();

        $data->name = 'Admin';
        $data->email = 'admin@demo.com';
        $data->password = Hash::make('12345678');
        $data->contact = '01111111111';
        $data->user_type = 'admin';

        $done = $data->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
