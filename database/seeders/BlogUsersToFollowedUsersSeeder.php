<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogUsersToFollowedUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'user_id' => 1,
            'followed_user_id' => 2
        ];
        $arr2 = [
            'user_id' => 2,
            'followed_user_id' => 1
        ];
        DB::table('blog_users_to_followed_users')->insert([$arr, $arr2]);
    }
}
