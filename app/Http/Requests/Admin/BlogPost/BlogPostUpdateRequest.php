<?php

namespace App\Http\Requests\Admin\BlogPost;

use App\Http\Requests\Admin\BaseRequests\BaseRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class BlogPostUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:5|max:255',
            'slug' => ['required', 'min:5', 'max:255',
                'unique' => Rule::unique('blog_posts')->ignore(Route::current()->parameter('post'))],
            'excerpt' => 'max:500',
            'content_raw' => 'required|string|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id',
            'status' => 'required'
        ];
    }
}
