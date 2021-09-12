<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        /*CREATE PERMISSION*/
        $permissions = [//default adalah web..tpi tukar kpd api bcoz usage middleware API
            ['name' => 'get_spikpa_user' , 'guard_name' => 'api'],
            ['name' => 'put_spikpa_user', 'guard_name' => 'api'],
            ['name' => 'post_spikpa_user', 'guard_name' => 'api'],
            ['name' => 'delete_spikpa_user', 'guard_name' => 'api'],
            ['name' => 'get_bms_user', 'guard_name' => 'api'],
            ['name' => 'put_bms_user', 'guard_name' => 'api'],
            ['name' => 'get_vcs_user', 'guard_name' => 'api'],
            ['name' => 'delete_vcs_user' , 'guard_name' => 'api']
        ];

        DB::table('permissions')->insert($permissions);

        /*CREATE ROLES*/
        $roles = [
            ['name' => 'spikpa', 'guard_name' => 'api'],
            ['name' => 'bms', 'guard_name' => 'api'],
            ['name' => 'vcs' , 'guard_name' => 'api']
        ];

        DB::table('roles')->insert($roles);

        /*ASSIGN PERMISSION KPD ROLE*/
        $roles = Role::all();
        $permissions = new Permission();

        foreach($roles as $role){
            if($role->name === 'spikpa') $role->givePermissionTo($permissions->where('name','LIKE','%spikpa%')->get());
            if($role->name === 'bms') $role->givePermissionTo($permissions->where('name','LIKE','%bms%')->get());
            if($role->name === 'vcs') $role->givePermissionTo($permissions->where('name','LIKE','%vcs%')->get());
        }

        $users = [
            [
                'name' => 'Admin',
                'email' =>  'admin@admin.com',
                'password' => Hash::make('Admin@123'),
                'status' => '1',
                'is_admin' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'vcs',
                'email' =>  'vcs@user.com',
                'password' => Hash::make('Admin@123'),
                'status' => '1',
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'bms',
                'email' =>  'bms@user.com',
                'password' => Hash::make('Admin@123'),
                'status' => '1',
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'spikpa',
                'email' =>  'spikpa@user.com',
                'password' => Hash::make('Admin@123'),
                'status' => '1',
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ];


        for($i = 0 ; $i < 10 ; $i++){
            $users[] = [
                'name' => $faker->name,
                'email' =>  $faker->unique()->safeEmail,
                'password' => Hash::make('Admin@123'),
                'status' => '1',
                'is_admin' => '0',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        /*ASSIGN ROLE TO USER */
        DB::table('users')->insert($users);
        $roles = Role::all();

        $admin = User::where('name','Admin')->first();
        $admin->assignRole($roles);

        $spikpa = User::where('name','spikpa')->first();
        $spikpa->assignRole($roles->where('name','spikpa'));

        $vcs = User::where('name','vcs')->first();
        $vcs->assignRole($roles->where('name','vcs'));

        $bms = User::where('name','bms')->first();
        $bms->assignRole($roles->where('name','bms'));

    }
}
