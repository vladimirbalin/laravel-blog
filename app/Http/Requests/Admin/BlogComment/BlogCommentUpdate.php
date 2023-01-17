<?php

namespace App\Http\Requests\Admin\BlogComment;

use App\Http\Requests\Admin\BaseRequests\BaseRequest;

class BlogCommentUpdate extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => 'required|max:10000|min:5',
            'status' => 'required'
        ];
    }
}
