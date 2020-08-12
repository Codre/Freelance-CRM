<?php

namespace App\Http\Controllers\Projects\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskCommentRequest extends FormRequest
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
            'text' => 'required',
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
            'text' => __('attributes/project.task.comment.text'),
        ];
    }
}
