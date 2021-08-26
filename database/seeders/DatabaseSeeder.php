<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(4)->create()
            ->each(function ($user) {
                $ids = range(1, 4);
                $ids = array_filter($ids, function ($val) use ($user) {
                    return $val != $user->id;
                });
                $user->followedUsers()->attach($ids[array_rand($ids)]);
            });
        $this->call(AdminUserSeeder::class);
        $this->call(BlogRootCategorySeeder::class);
        BlogCategory::factory(9)->create();
        BlogPost::factory(100)->create()
            ->each(function ($post) {
                $post->users()->attach(rand(1, 2));
            });
        BlogTag::factory(5)->create();
        BlogComment::factory(200)->create();
    }
}
