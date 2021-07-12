<?php

namespace Database\Factories;

use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BlogCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $content = $this->faker->sentence;
        $status = rand(0, 1);
        $post_id = rand(1, 100);
        $user_id = rand(1, 2);
        $createdAt = $this->faker->dateTimeBetween('-5 years')->format('Y-m-d H:i:s');

        $isPublished = rand(1, 5) > 1;

        return [
            'content' => $content,
            'status' => $status,
            'post_id' => $post_id,
            'user_id' => $user_id,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
            'published_at' => $isPublished ? $createdAt : null
        ];
    }
}
