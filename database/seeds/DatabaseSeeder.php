<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
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

        for($i = 0 ; $i < 100 ; $i++){
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' =>  $faker->unique()->safeEmail,
                'password' => Hash::make('Admin@123'),
                'status' => '1',
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
