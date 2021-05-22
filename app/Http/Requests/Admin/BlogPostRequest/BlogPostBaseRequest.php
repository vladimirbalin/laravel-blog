<?php


namespace App\Http\Requests\Admin\BlogPostRequest;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogPostBaseRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->setSlugFromTitle();
    }

    protected function setSlugFromTitle()
    {
        $titleShouldBeConverted =
            $this->exists(['slug', 'title']) &&
            $this->isNotFilled('slug') && $this->filled('title');

        if ($titleShouldBeConverted) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }
    }
}
