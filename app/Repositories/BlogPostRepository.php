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

    public function getEdit($id)
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
            ->orderBy('id', 'DESC')
            ->paginate($perPage);

        return $result;
    }
}
