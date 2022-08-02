<?php


namespace App\Repositories;


use App\Models\BlogComment as Model;

class BlogCommentRepository extends Repository
{

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getAll()
    {
        $result = $this->start()
            ->with('user', 'post')
            ->latest('id')
            ->get();

        return $result;
    }

    public function getAllWithPaginator(int $perPage)
    {
        $result = $this->start()
            ->with('user', 'post')
            ->latest('id')
            ->paginate($perPage);

        return $result;
    }

    /**
     * Get collection of published comments of given post
     * @param $postId
     * @return mixed
     */
    public function getAllPublishedByPost($postId)
    {
        $result = $this->start()
            ->where('status', '=', 1)
            ->where('post_id', '=', $postId)
            ->latest()
            ->get();

        return $result;
    }

    public function getAllPublishedWithPaginatorByPost($postId, int $perPage)
    {
        $result = $this->start()
            ->where('status', '=', 3)
            ->where('post_id', '=', $postId)
            ->latest()
            ->paginate($perPage);

        return $result;
    }

    /**
     * Get model of comment with given id.
     * @param $commentId
     * @return mixed
     */
    public function getExactComment($commentId)
    {
        $result = $this->start()
            ->find($commentId);

        return $result;
    }
}
