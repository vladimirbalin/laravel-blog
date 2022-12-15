<?php

namespace App\Repositories;

use App\Models\BlogCategory;
use App\Models\BlogPost as Model;
use \Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BlogPostRepository extends Repository
{
    private $query;

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getAll(): array|Collection
    {
        $result = $this
            ->start()
            ->all();

        return $result;
    }

    public function getExactPostBySlug($slug): EloquentModel
    {
        $result = $this
            ->start()
            ->firstWhere('slug', $slug);

        return $result;
    }

    public function getAllWithPaginator($perPage): array|Collection
    {
        $columns = ['id', 'category_id', 'user_id', 'title', 'status', 'published_at'];
        $result = $this
            ->start()
            ->select($columns)
            ->with(['user:id,name', 'category:id,title'])
            ->latest('id')
            ->paginate($perPage);

        return $result;
    }

    public function getAllPublishedWithPaginatorByCategorySortedBy(
        $sortedBy = '',
        $category = '',
        $perPage = 5
    ): LengthAwarePaginator
    {
        $this->allPublishedQuery()
            ->sortedBy($sortedBy)
            ->byCategory($category);

        $paginator = $this
            ->query
            ->with(['user:id,name', 'category:id,title,slug', 'likedUsers'])
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        return $paginator;
    }

    public function allPublishedQuery()
    {
        $columns = ['id', 'category_id', 'slug', 'user_id', 'content_html', 'title', 'published_at'];
        $this->query = $this
            ->start()
            ->select($columns)
            ->where('status', '=', 1);

        return $this;
    }

    public function byCategory($category = "")
    {
        if (!$category) {
            return $this;
        }

        $category = BlogCategory::where(['slug' => $category])->first();

        if (isset($category)) {
            $this->query = $this->query->where(['category_id' => $category->id]);
            return $this;
        }

        throw new \InvalidArgumentException('Cannot sort by this category field');
    }

    public function sortedBy($sortedBy = "")
    {
        if (!$sortedBy) {
            return $this;
        }

        $startedWithMinus = substr($sortedBy, 0, 1) === '-';
        if ($startedWithMinus) {
            $sortedBy = substr($sortedBy, 1);
        }

        if (!isset($this->start()->first()->$sortedBy)) {
            throw new \InvalidArgumentException('Cannot sort by this field');
        }

        $sorted = $this->start()
            ->with(['likedUsers:id,name'])
            ->get()
            ->sortBy([[$sortedBy, $startedWithMinus ? 'desc' : 'asc']])
            ->pluck('id')
            ->toArray();
        $orderedIds = implode(',', $sorted);
        $this->query = $this->query
            ->orderByRaw(DB::raw('FIELD(id, ' . $orderedIds . ')'));

        return $this;
    }

    /**
     * Get posts, ordered by likes in descending order
     *
     * @param $postsCount
     * Amount of posts to get
     * @param $subMonths
     * Amount of months before now
     *
     * @return array
     */
    public function topByLikes($postsCount, $subMonths): array
    {
        $minusMonthsDateTime = Carbon::now()
            ->subMonths($subMonths)
            ->toDateTimeString();

        $posts = DB::select('SELECT users.name                                  AS author,
                                    bp.created_at,
                                    bp.title,
                                    bp.id                                       AS id,
                                    bp.slug                                     AS slug,
                                    IF(ISNULL(blog_likes.post_id), 0, COUNT(*)) AS count
                               FROM blog_likes
                         RIGHT JOIN blog_posts as bp ON blog_likes.post_id = bp.id
                         INNER JOIN users ON bp.user_id = users.id
                              WHERE bp.created_at > "' . $minusMonthsDateTime . '"
                           GROUP BY blog_likes.post_id,
                                    users.name,
                                    bp.created_at,
                                    bp.title,
                                    bp.id,
                                    slug
                           ORDER BY count DESC,
                                    created_at DESC
                              LIMIT ' . $postsCount);
        $sequence = 1;
        foreach ($posts as $post) {
            $post->sequence_number = $sequence++;
        }

        return $posts;
    }
}
