<?php


namespace App\Repositories;


use App\Models\BlogCategory;
use App\Models\BlogPost as Model;
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

    public function getAll()
    {
        $result = $this->start()
            ->all();

        return $result;
    }

    public function getExactPost($id)
    {
        $result = $this->start()
            ->find($id);
        return $result;
    }

    public function getAllWithPaginator($perPage)
    {
        $columns = ['id', 'category_id', 'user_id', 'title', 'is_published', 'published_at'];

        $result = $this->start()
            ->select($columns)
            ->with(['user:id,name', 'category:id,title'])
            ->latest('id')
            ->paginate($perPage);

        return $result;
    }

    public function getAllPublishedWithPaginatorByCategorySortedBy($sortedBy = '', $category = '', $perPage = 5)
    {
        $this->allPublishedQuery()
            ->sortedBy($sortedBy)
            ->byCategory($category);

        $paginator = $this->query
            ->with(['user:id,name', 'category:id,title,slug', 'likedUsers'])
            ->paginate($perPage);

        return $paginator;
    }

    public function allPublishedQuery()
    {
        $columns = ['id', 'category_id', 'user_id', 'content_html', 'title', 'published_at'];

        $this->query = $this->start()
            ->select($columns)
            ->where('is_published', '=', true);

        return $this;
    }

    public function byCategory($category = "")
    {
        if (! $category) {
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
        if (! $sortedBy) {
            return $this;
        }

        if (! $this->start()->first()->$sortedBy) {
            throw new \InvalidArgumentException('Cannot sort by this field');
        }

        $startedWithMinus = substr($sortedBy, 0, 1) === '-';
        if ($startedWithMinus) {
            $sortedBy = substr($sortedBy, 1);
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
}
