<?php

namespace Database\Factories;

use App\Models\BlogUsersToLikedPosts;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogUsersToLikedPostsFactory extends Factory
{
    protected $model = BlogUsersToLikedPosts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = rand(1, 2);
        $post_id = $this->faker->unique()->numberBetween(1, 100);
        return [
            'user_id' => $user_id,
            'post_id' => $post_id
        ];
    }
}
