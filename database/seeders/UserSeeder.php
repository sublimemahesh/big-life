<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                //Super Admin
                [
                    'super_parent_id' => null,
                    'name' => 'Super Admin',
                    'username' => 'super_admin',
                    'email' => 'noreply@wintogetherplan.com',
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => Hash::make('Xl&6!O#8@m%$9M'), // password
                ],
                //Admin
                [
                    'super_parent_id' => null,
                    'name' => 'James caron',
                    'username' => 'admin',
                    'email' => 'noreply@wintogetherplan.com',
                    'email_verified_at' => null,
                    'phone_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => Hash::make('Xl&6!O#8@m%$9M'), // password
                ],
                //User
                [
                    'super_parent_id' => null,
                    'name' => 'Alex John',
                    'username' => 'Alex',
                    'email' => 'nuwanprasad19780509@gmail.com',
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => Hash::make('Xl&6!O#8@m%$9M'), // password
                ],
            ]
        );
        DB::table('profiles')->insert(
            [
                //Super Admin
                [
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                //Admin
                [
                    'user_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                //User
                [
                    'user_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
