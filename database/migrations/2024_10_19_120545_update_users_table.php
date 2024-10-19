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
        Schema::table('users', function (Blueprint $table) {

            $table->string('phone_number')->unique()->nullable()->after('email');  // Phone number
            $table->string('role')->nullable()->after('phone_number');             // Role like Admin, Trainer, etc.
            $table->string('address')->nullable()->after('role');                  // Address
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('address'); // Gender
            $table->string('profile_image')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'role', 'address', 'gender', 'profile_image']);
        });
    }
};
