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
     * Get array of stdClasses for dropdown list of categories
     * @return array
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
