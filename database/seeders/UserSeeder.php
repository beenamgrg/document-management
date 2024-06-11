<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'role' => 'admin',
                    'password' => Hash::make('admin')
                ],
                [
                    'id' => 2,
                    'name' => 'User 1',
                    'email' => 'user1@gmail.com',
                    'role' => 'user',
                    'password' => Hash::make('user')
                ],
                [
                    'id' => 3,
                    'name' => 'User 2',
                    'email' => 'user2@gmail.com',
                    'role' => 'user',
                    'password' => Hash::make('user')
                ],
                [
                    'id' => 4,
                    'name' => 'User 3',
                    'email' => 'user3@gmail.com',
                    'role' => 'user',
                    'password' => Hash::make('user')
                ],
            ]
        );
    }
}
