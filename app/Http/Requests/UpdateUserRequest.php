<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$this->id.'|max:100',
            'password' => $this->password ? 'min:6|confirmed' : '',
            'group_id' => ['required', Rule::in(Group::STAFFS)]
        ];
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        $data = parent::getFormData();
        $data['name'] = ucfirst($data['name']);

        return $data;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('attributes/user.name'),
            'email' => __('attributes/user.email'),
            'password' => __('attributes/user.password'),
            'group_id' => __('attributes/user.group_id'),
        ];
    }
}
