<?php

namespace App\Http\Requests\Admin\BlogCategory;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class BlogCategoryUpdateRequest extends BlogCategoryBaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:200',
            'slug' => [
                'required',
                'max:200',
                Rule::unique('blog_categories')
                    ->ignore(Route::current()->parameter('category')),
            ],
            'parent_id' => 'required|integer|exists:blog_categories,id',
            'description' => 'required|min:10|max:500'
        ];
    }
}
