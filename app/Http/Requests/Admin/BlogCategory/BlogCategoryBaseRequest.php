<?php


namespace App\Http\Requests\Admin\BlogCategory;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogCategoryBaseRequest extends FormRequest
{
    public function messages()
    {
        return [
          'slug.unique' => 'Please change or enter the unique slug.'
        ];
    }

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
