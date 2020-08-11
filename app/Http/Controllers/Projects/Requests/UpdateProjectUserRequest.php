<?php

namespace App\Http\Controllers\Projects\Requests;

use App\Http\Requests\FormRequest;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProjectUserRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'group_id' => [Rule::in(array_keys(ProjectUser::getGroups()))]
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
            'user_id' => __('attributes/project.member.user_id'),
            'group_id' => __('attributes/project.member.group_id'),
        ];
    }
}
