<?php

namespace App\Repositories;

use App\Models\User as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BlogUserRepository extends Repository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Get authors who have most likes
     *
     * @param $usersCount
     * Amount of authors to get
     * @param $subMonths
     * Amount of months before now
     *
     * @return array
     */
    public function topByLikes($usersCount, $subMonths): array
    {
        $minusMonthsDateTime = Carbon::now()
            ->subMonths($subMonths)
            ->toDateTimeString();

        $users = DB::select('SELECT query_in.id,
                                    query_in.name,
                                    SUM(query_in.count) AS likes_count
                               FROM (
                                      SELECT users.id   AS id,
                                             users.name AS name,
                                             count(*)   AS count
                                      FROM users
                                               INNER JOIN blog_posts ON users.id = blog_posts.user_id
                                               INNER JOIN blog_likes ON blog_posts.id = blog_likes.post_id
                                      WHERE blog_posts.created_at > "' . $minusMonthsDateTime . '"
                                      GROUP BY post_id,
                                               users.name,
                                               users.id
                                    ) AS query_in
                            GROUP BY id
                            ORDER BY likes_count DESC
                            LIMIT ' . $usersCount);
        $sequence_number = 1;
        foreach ($users as $user) {
            $user->sequence_number = $sequence_number++;
        }

        return $users;
    }

    /**
     * Get all posts
     * @return Collection
     */
    public function getAll(): Collection
    {
        $result = $this
            ->start()
            ->all();

        return $result;
    }
}
