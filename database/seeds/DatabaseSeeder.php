<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' =>  'admin@admin.com',
            'password' => Hash::make('Admin@123'),
            'status' => '1',
            'is_admin' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' =>  'user@user.com',
            'password' => Hash::make('Admin@123'),
            'status' => '1',
            'is_admin' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
