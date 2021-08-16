<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'phone' => 'required|string',
            'name' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                'unique' => Rule::unique('users')
                    ->ignore(Route::current()
                    ->parameter('profile'))
            ],
        ];
    }
}
