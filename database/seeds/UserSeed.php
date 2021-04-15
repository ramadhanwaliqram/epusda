<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $superadmin = Role::where('name', 'superadmin')->first();
        $user = Role::where('name', 'user')->first();

        $superadmins = User::create([
            'name'      => 'Superadmin',
            'username'  => 'superadmin',
            'password'  => bcrypt('superadmin'),
            'role_id'   => 1
        ]);

        $users = User::create([
            'name'      => 'User',
            'username'  => 'user',
            'password'  => bcrypt('user'),
            'role_id'   => 2
        ]);


        $superadmins->roles()->attach($superadmin);
        $users->roles()->attach($user);
    }
}
