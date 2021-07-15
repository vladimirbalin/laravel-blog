<?php


namespace App\Repositories;


use App\Models\BlogTag as Model;

class BlogTagRepository extends Repository
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
        return $this->start()
            ->latest()
            ->get();
    }

}
