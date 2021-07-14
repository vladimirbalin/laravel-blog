<?php


namespace App\Http\Requests\Admin\BlogCategory;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogCategoryBaseRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

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
