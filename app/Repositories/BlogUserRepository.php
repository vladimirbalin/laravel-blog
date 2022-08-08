<?php


namespace App\Repositories;


use App\Models\BlogCategory;
use App\Models\User as Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BlogUserRepository extends Repository
{
    private $query;

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getAll()
    {
        $result = $this->start()
            ->all();

        return $result;
    }

    /**
     * Get total likes to each user(author)
     *
     * @return \Illuminate\Support\Collection
     */
    public function topByLikes($subMonths)
    {
        $minusMonths = Carbon::now()->subMonths($subMonths);

        return DB::query()->fromSub(function ($query) use ($minusMonths) {
            $query->from('users')
                ->join('blog_posts', 'users.id', '=', 'blog_posts.user_id')
                ->join('blog_likes', 'blog_posts.id', '=', 'blog_likes.post_id')
                ->where('blog_posts.created_at', '>', $minusMonths)
                ->selectRaw('users.id as id, users.name as name, count(*) as count')
                ->groupBy('post_id', 'users.name', 'users.id');
        }, 'query_in')
            ->selectRaw('query_in.id, query_in.name, SUM(query_in.count) as likes_count')
            ->groupBy('id')
            ->orderBy('likes_count', 'DESC')
            ->get()
            ->toBase();
    }
}
