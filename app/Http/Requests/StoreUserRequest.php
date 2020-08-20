<?php

namespace App\Http\Requests;


use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUserRequest extends UpdateUserRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:6|confirmed',
            'group_id' => ['required', Rule::in(Group::STAFFS)]
        ];
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        $data = parent::getFormData();

        $data['created_at'] = Carbon::create()->subDay();
        $data['balance'] = 0;
        $data['password'] = Hash::make($data['password']);

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
