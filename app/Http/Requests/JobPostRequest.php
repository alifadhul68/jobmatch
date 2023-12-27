<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'featured_image' => 'required|mimes:png,jpeg,jpg|max:10240',
            'description' => 'required',
            'roles' => 'required',
            'job_type' => 'required',
            'address' => 'required',
            'salary' => 'required|numeric|digits_between:1,13',
            'due' => 'required',
        ];
    }
}
