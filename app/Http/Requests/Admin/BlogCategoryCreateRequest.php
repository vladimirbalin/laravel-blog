<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryCreateRequest extends FormRequest
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
            'title' => 'required|min:5|max:200',
            'slug' => [
                'max:200',
                Rule::unique('blog_categories')
                    ->ignore(Route::current()->parameter('category')),
            ],
            'parent_id' => 'required|integer|exists:blog_categories,id',
            'description' => 'required|min:10|max:500'
        ];
    }
    protected function prepareForValidation()
    {
        if (!$this->slug) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }
    }
}
