<?php

namespace App\Http\Requests\Web\BaseRequests;

use Illuminate\Support\Str;

class BlogPostBaseRequest extends BaseRequest
{
    protected function prepareForValidation()
    {
        $this->setSlugFromTitle();
    }

    protected function setSlugFromTitle()
    {
        $titleShouldBeConverted =
            $this->exists(['slug', 'title'])
            && $this->isNotFilled('slug')
            && $this->filled('title');

        if ($titleShouldBeConverted) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }
    }
}
