<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8));
        $text = $this->faker->realText(rand(1000, 4000));
        $isPublished = rand(1, 5) > 1;
        $createdAt = $this->faker
            ->dateTimeBetween('-2 months', '-1 days')
            ->format('Y-m-d H:i:s');

        return [
            'category_id' => rand(1, 10),
            'user_id' => (rand(1, 3) === 3) ? 1 : 2,
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->text(rand(40, 100)),
            'content_raw' => $text,
            'content_html' => $text,
            'is_published' => $isPublished,
            'published_at' => $isPublished
                ? Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->addDays(2)
                : null,
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
