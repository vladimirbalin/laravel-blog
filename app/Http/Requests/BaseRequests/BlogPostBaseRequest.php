<?php

namespace App\Http\Requests\BaseRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostBaseRequest extends FormRequest
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
