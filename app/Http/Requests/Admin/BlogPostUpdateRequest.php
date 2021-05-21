<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255',
            'slug' => 'min:5|max:255',
            'excerpt' => 'max:500',
            'content_raw' => 'required|string|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id'
        ];
    }
}
