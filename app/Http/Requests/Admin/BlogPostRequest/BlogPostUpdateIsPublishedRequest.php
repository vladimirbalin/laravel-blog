<?php


namespace App\Http\Requests\Admin\BlogPostRequest;


class BlogPostUpdateIsPublishedRequest extends BlogPostBaseRequest
{
    public function rules()
    {
        return [
            'is_published' => 'required'
        ];
    }
}
