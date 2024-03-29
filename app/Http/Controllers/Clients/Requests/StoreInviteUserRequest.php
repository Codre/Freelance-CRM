<?php

namespace App\Http\Controllers\Clients\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreInviteUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'min:6|confirmed',

        ];
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        $data = parent::getFormData();
        $data['password'] = Hash::make(app(\Faker\Generator::class)->password);

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
            'password' => __('attributes/user.password'),
        ];
    }
}
