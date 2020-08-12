<?php

namespace App\Http\Controllers\Projects\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProjectTaskRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => __('attributes/project.task.title'),
            'description' => __('attributes/project.task.description'),
        ];
    }
}
