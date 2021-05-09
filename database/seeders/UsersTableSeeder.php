<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Unknown author',
                'email' => 'author_unknown@google.com',
                'password' => bcrypt(Str::random(16))
            ],
            [
                'name' => 'Vladimir',
                'email' => 'vladimir@google.com',
                'password' => bcrypt(12345)
            ]
        ];
        DB::table('users')->insert($users);
    }
}
