<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            'public_id' => 8149561969004949,
            'full_name' => 'Amit Bisen',
            'mobile_number' => 7987124272,
            'country_code' => 91,
            'role' => 'admin',
            'email' => 'admin@instantcatalog.com',
            'password' => Hash::make('123@Bisen321'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_admin_user');
    }
};
