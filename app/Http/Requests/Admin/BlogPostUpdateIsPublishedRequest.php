<?php


namespace App\Http\Requests\Admin;


use App\Repositories\BlogPostRepository;

class BlogPostUpdateIsPublishedRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules()
    {
        return [
            'is_published' => 'required'
        ];
    }
}
