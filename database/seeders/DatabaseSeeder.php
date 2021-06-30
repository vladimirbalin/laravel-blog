<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
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
        User::factory(2)->create();
        $this->call(AdminUserSeeder::class);

        $this->call(BlogRootCategorySeeder::class);
        BlogCategory::factory(9)->create();
        BlogPost::factory(100)->create();
    }
}
