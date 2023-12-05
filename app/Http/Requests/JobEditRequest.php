<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobEditRequest extends FormRequest
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
            'title' => 'required|min:5',
            'featured_image' => 'mimes:png,jpeg,jpg|max:2048',
            'description' => 'required|min:200',
            'roles' => 'required',
            'job_type' => 'required',
            'address' => 'required',
            'salary' => 'required',
            'due' => 'required',
        ];
    }
}
