<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Web\BaseRequests\BaseRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends BaseRequest
{

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
