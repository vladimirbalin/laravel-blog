<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogRootCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryName = 'Без категории';
        $category['parent_id'] = 0;
        $category['title'] = $categoryName;
        $category['slug'] = Str::slug($categoryName);
        $category['created_at'] = Carbon::now();
        $category['updated_at'] = Carbon::now();

        DB::table('blog_categories')->insert($category);
    }
}
