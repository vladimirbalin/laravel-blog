<?php


namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogCategoryFactory extends Factory
{

    public function definition()
    {
        $category = [];
        $categoryName = "Категория " . $this->faker->unique()->word();
        $category['parent_id'] = rand(1, 4);
        $category['title'] = $categoryName;
        $category['slug'] = Str::slug($categoryName);
        return $category;
    }
}
