<?php

namespace Database\Factories;

use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\User;
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
        $status = rand(1, 5) > 1;
        $post_id = BlogPost::all()->random()->id;
        $user_id = User::all()->random()->id;
        $createdAt = $this->faker->dateTimeBetween('-1 years')->format('Y-m-d H:i:s');

        return [
            'content' => $content,
            'status' => $status,
            'post_id' => $post_id,
            'user_id' => $user_id,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
            'published_at' => $status ? $createdAt : null
        ];
    }
}
