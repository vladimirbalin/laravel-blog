<?php

namespace App\Http\Requests\Posts;


use Illuminate\Support\Facades\Auth;

class BlogPostCreateRequest extends BlogPostBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255',
            'excerpt' => 'max:500',
            'content_raw' => 'required|string|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id'
        ];
    }
    protected function prepareForValidation()
    {
        parent::prepareForValidation();
        $this->merge([
            'user_id' => auth()->user()->id
        ]);
    }
}
