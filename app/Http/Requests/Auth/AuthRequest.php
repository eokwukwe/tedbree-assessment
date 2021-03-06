<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
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
            'name' => ['string', 'max:255', Rule::requiredIf(!$this->isLoginPath())],
            'email' => [
                'required', 'string', 'email', 'max:255',
                !$this->isLoginPath() ? 'unique:users' : ''
            ],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    protected function isLoginPath()
    {
        return $this->path() == 'v1/login';
    }
}
