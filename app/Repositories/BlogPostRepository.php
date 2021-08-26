<?php


namespace App\Repositories;


use App\Models\BlogPost as Model;

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
        $columns = ['id', 'category_id', 'user_id', 'content_html', 'title', 'published_at'];

        $result = $this->start()
            ->select($columns)
            ->where('is_published', '=', true)
            ->with(['user:id,name', 'category:id,title', 'users'])
            ->latest('id')
            ->paginate($perPage);

        return $result;
    }
}
