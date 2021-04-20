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
            'name'              => 'Superadmin',
            'email'             => 'superadmin@literasia.co.id',
            'password'          => bcrypt('superadmin'),
            'no_phone'          => '081234567890',
            'email_verified_at' => '2020-04-04',
            'role_id'           => 1
        ]);

        $users = User::create([
            'name'              => 'User',
            'email'             => 'user@literasia.co.id',
            'password'          => bcrypt('user'),
            'no_phone'          => '081234567891',
            'email_verified_at' => '2020-04-04',
            'role_id'           => 2
        ]);


        $superadmins->roles()->attach($superadmin);
        $users->roles()->attach($user);
    }
}
