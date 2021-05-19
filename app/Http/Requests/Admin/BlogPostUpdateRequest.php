<?php

namespace App\Http\Requests\Admin;

use App\Repositories\BlogPostRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class BlogPostUpdateRequest extends FormRequest
{
    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->blogPostRepository = app(BlogPostRepository::class);
    }

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

    protected function prepareForValidation()
    {
        if($this->ajax()){
            $ajaxAttributeToChange = 'is_published';

            $post = $this->blogPostRepository->getExactPost($this->id);
            $dbValues = $post->attributesToArray();
            Arr::pull($dbValues, $ajaxAttributeToChange);

            $this->merge($dbValues);
        }
    }
}
