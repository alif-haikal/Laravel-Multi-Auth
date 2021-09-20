<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SpikpaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        Schema::connection("sqlsrv")->dropIfExists('users');

        Schema::connection('sqlsrv')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status');
            $table->string('is_admin');
            $table->rememberToken();
            $table->timestamps();
        });


        $users = [];
        for($i = 0 ; $i < 50 ; $i++){
            $users[] = [
                'name' => $faker->name,
                'email' =>  $faker->unique()->safeEmail,
                'password' => Hash::make('Admin#123'),
                'status' => '1',
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::connection('sqlsrv')->table('users')->insert($users);

    }
}
