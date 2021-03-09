<?php

namespace App\Http\Requests\Jobs;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationsRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:200'],
            'last_name' => ['required', 'string', 'max:200'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('job_applications')->where(function ($query) {
                    $query->where(['job_id' => $this->job->id]);
                })
            ],
            // https://stackoverflow.com/questions/42397800/how-can-i-validate-nigeria-mobile-phone-numbers-using-regex
            'phone' => [
                'required', 'string', 'regex:/(^[0]\d{10}$)|(^[\+]?[234]\d{12}$)/'
            ],
            'location' => ['required', 'string', 'max:200'],
            'cv' => ['required', 'max:2000', 'mimes:jpeg,jpg,png,pdf'],
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
            'email.unique' => 'You have already applied for this job.',
            'cv.max' => 'The cv may not be greater than 2MB.',
        ];
    }
}
