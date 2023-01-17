<?php

namespace App\Http\Requests\Admin\BlogCategory;

use App\Http\Requests\Admin\BaseRequests\BaseRequest;
use Illuminate\Support\Str;

class BlogCategoryBaseRequest extends BaseRequest
{

    public function messages(): array
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
