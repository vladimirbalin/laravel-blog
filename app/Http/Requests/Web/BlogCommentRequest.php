<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Web\BaseRequests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class BlogCommentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|max:10000',
            'status' => 'int|min:0|max:3'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->user()->id
        ]);
    }
}
