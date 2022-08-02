<?php


namespace App\Http\Requests\Admin\BlogComment;


use App\Http\Requests\Admin\BaseRequests\BaseRequest;

class BlogCommentUpdateIsPublishedRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'status' => 'required'
        ];
    }
}
