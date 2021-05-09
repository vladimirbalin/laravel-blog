<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];
        $categoryName = 'Без категории';

        $categories[] = [
            'parent_id' => 0,
            'slug' => Str::slug($categoryName),
            'title' => $categoryName
        ];

        for ($i = 1; $i <= 10; $i++) {
            $categoryName = "Категория #$i";
            $categories[] = [
                'parent_id' => $i > 4 ? rand(1, 4) : 1,
                'slug' => Str::slug($categoryName),
                'title' => $categoryName
            ];
        }

        DB::table('blog_categories')->insert($categories);
    }
}
