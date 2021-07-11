<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    private $num = 0;
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
        $createdAt = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Carbon::now()
                ->addMonths('-6')
                ->addDays($this->num)
        );
        $this->num++;
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
                ? Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->addDays('1')
                : null,
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
