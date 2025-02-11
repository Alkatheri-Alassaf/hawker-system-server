<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userID = DB::table('users')->insert([
            'firstName' => 'Admin',
            'lastName' => 'User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('0097'),
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a corresponding record in the 'admins' table
        DB::table('admins')->insert([
            'userID' => $userID,
        ]);
    }
}
