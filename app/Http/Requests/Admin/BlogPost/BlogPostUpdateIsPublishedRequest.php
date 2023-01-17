<?php

namespace App\Http\Requests\Admin\BlogPost;

use App\Http\Requests\Admin\BaseRequests\BaseRequest;

class BlogPostUpdateIsPublishedRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required'
        ];
    }
}
