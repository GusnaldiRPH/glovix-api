<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'total_exp' => 0,
            'current_level_id' => 1,
        ]);

        // Buat user biasa
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@lms.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'total_exp' => 0,
            'current_level_id' => 1,
        ]);

        // Buat wallet untuk user
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 1000000,
        ]);
    }
}