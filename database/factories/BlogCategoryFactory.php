<?php


namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogCategoryFactory extends Factory
{

    public function definition()
    {
        $category = [];
        $categoryName = $this->faker->unique()->word() . " category";
        $category['parent_id'] = rand(1, 4);
        $category['title'] = $categoryName;
        $category['slug'] = Str::slug($categoryName);
        return $category;
    }
}
