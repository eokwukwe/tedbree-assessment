<?php

namespace App\Http\Requests\Jobs;

use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;

class JobsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            return $this->user()->can('update', $this->job);
        }

        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:200'],
            'description' => ['sometimes', 'required', 'string'],
            'location' => ['sometimes', 'required', 'string'],
            'company' => ['sometimes', 'required', 'string'],
            'benefits' => ['sometimes', 'required', 'string'],
            'salary' => ['sometimes', 'required', 'string'],
            'type' => ['sometimes', 'required', 'string', 'exists:App\Models\Type,name'],
            'category' => [
                'sometimes', 'required', 'string', 'exists:App\Models\Category,name'
            ],
            'work_condition' => [
                'sometimes', 'required', 'string', 'exists:App\Models\Condition,name'
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type.exists' => 'The selected type does not exist.',

            'work_condition.exists' => 'The selected work condition does not exist.',

            'category.exists' => 'The selected category does not exist.',
        ];
    }
}
