<?php

namespace App\Http\Requests\User\BorrowBook;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfoUserRequest extends FormRequest
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
            'name' => [
                'required',
                'max:30',
            ],
            'email' => [
                'required',
                'email',
            ],
            'code' => [
                'required',
                Rule::unique('users', 'code'),
            ],
            'returnDate' => [
                'required',
                'after_or_equal:' . date('Y-m-d'),
            ],
        ];
    }
}
