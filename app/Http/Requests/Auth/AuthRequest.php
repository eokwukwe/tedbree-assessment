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
        return $this->isLoginPath() ? $this->loginRules() : $this->registerRules();
    }

    /**
     * Login path
     */
    protected function isLoginPath(): string
    {
        return $this->path() == 'v1/login';
    }

    /**
     * Login rules
     */
    protected function loginRules(): array
    {

        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    /**
     * Login rules
     */
    protected function registerRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
