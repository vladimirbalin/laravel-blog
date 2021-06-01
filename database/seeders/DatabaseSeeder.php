<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
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
         \App\Models\User::factory(2)->create();
         \App\Models\User::factory()->adminAccount()->create();
//        $this->call(UsersTableSeeder::class);
        $this->call(BlogRootCategorySeeder::class);
        BlogCategory::factory(9)->create();
        BlogPost::factory(100)->create();
    }
}
