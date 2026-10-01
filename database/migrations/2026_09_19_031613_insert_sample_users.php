<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'pandowoharjo',
                'email' => 'admin@kalurahanpandowoharjo.com',
                'password' => Hash::make('pandowoharjo2026'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pandowoharjo',
                'email' => 'petugas@kalurahanpandowoharjo.com',
                'password' => Hash::make('pandowoharjo2025'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('users')
            ->whereIn('email', [
                'admin@kalurahanpandowoharjo.com',
                'petugas@kalurahanpandowoharjo.com',
            ])
            ->delete();
    }
};