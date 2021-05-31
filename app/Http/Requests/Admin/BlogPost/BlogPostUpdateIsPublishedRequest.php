<?php


namespace App\Http\Requests\Admin\BlogPost;


use App\Http\Requests\Posts\BlogPostBaseRequest;
use Illuminate\Support\Facades\Auth;

class BlogPostUpdateIsPublishedRequest extends BlogPostBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->is_admin;
    }
    public function rules()
    {
        return [
            'is_published' => 'required'
        ];
    }
}