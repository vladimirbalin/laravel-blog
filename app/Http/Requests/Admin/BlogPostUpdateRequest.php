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
            'title' => 'min:5|max:255',
            'slug' => 'min:5|max:255',
            'excerpt' => '',
            'content_raw' => '',
            'content_html' => '',
            'is_published' => 'boolean'
        ];
    }
}
