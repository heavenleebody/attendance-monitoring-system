<?php

// Randell added this file | October 4, 2026 | 11:36 AM | Adds username (unique) and role (admin/user) to the users table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // nullable so old rows (like the seeder's test user) still fit
            $table->string('username')->nullable()->unique()->after('name');

            // only admins for now, 'user' is for later
            $table->string('role')->default('admin')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'role']);
        });
    }
};
