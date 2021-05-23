<?php


namespace App\Repositories;


use App\Models\BlogCategory as Model;

class BlogCategoryRepository extends Repository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Get Model for editing in admin layer
     * @param $id
     * @return mixed
     */
    public function getEdit($id)
    {
        $result = $this->start()
            ->find($id);
        return $result;
    }

    /**
     * Get array of Models for dropdown list
     * @return mixed
     */
    public function getDropDownList()
    {
        $columns = implode(', ', ['id', 'title', 'parent_id',
            "CONCAT (`id`, '. ', `title`) AS select_title"]);
        $result = $this->start()
            ->selectRaw($columns)
            ->toBase()
            ->get();
        return $result;
    }

    /**
     * Get array of Models for index page with pagination
     */
    public function getAllWithPagination($perPage)
    {
        $columns = ['id', 'title', 'parent_id', 'created_at'];
        $result = $this->start()
            ->select($columns)
            ->with(['parentCategory:id,title'])
            ->paginate($perPage);
        return $result;
    }

}
