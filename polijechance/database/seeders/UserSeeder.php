<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt(1234),
                'role' => 'admin'
            ],
            [
                'name' => 'zul',
                'email' => 'zulfikaryuniar06@gmail.com',
                'password' => bcrypt(1234),
                'role' => 'user'
            ],
            [
                'name' => 'heri',
                'email' => 'heri@gmail.com',
                'password' => bcrypt(1234),
                'role' => 'super-admin'
            ]
            ]);
    }
}
