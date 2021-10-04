<?php


namespace App\Repositories;


use App\Models\BlogPost as Model;
use Illuminate\Support\Facades\DB;

class BlogPostRepository extends Repository
{
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

    public function getAllPublishedWithPaginator($perPage)
    {
        $result = $this->allPublishedQuery()
            ->with(['user:id,name', 'category:id,title', 'likedUsers'])
            ->withCount('likedUsers')
            ->latest('id')
            ->paginate($perPage);

        return $result;
    }

    public function getAllPublishedWithPaginatorSortedBy($sortedBy, $perPage = 5)
    {
        $startedWithMinus = substr($sortedBy, 0, 1) === '-';
        if($startedWithMinus){
            $sortedBy = substr($sortedBy, 1);
        }
        $sorted = $this->allPublishedQuery()
            ->with('likedUsers:id')
            ->get()
            ->sortBy([[$sortedBy, $startedWithMinus ? 'desc' : 'asc']])
            ->pluck('id')
            ->toArray();

        $orderedIds = implode(',', $sorted);

        $paginator = $this->allPublishedQuery()
            ->with(['user:id,name', 'category:id,title', 'likedUsers'])
            ->orderByRaw(DB::raw('FIELD(id, ' . $orderedIds . ')'))
            ->paginate($perPage);

        return $paginator;
    }

    public function allPublishedQuery()
    {
        $columns = ['id', 'category_id', 'user_id', 'content_html', 'title', 'published_at'];

        $query = $this->start()
            ->select($columns)
            ->where('is_published', '=', true);

        return $query;
    }
}
