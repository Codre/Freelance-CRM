<?php

namespace App\Http\Controllers\Clients\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreClientRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email|max:100',
        ];
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        $data = parent::getFormData();
        $data['name'] = ucfirst($data['name']);
        $data['password'] = Hash::make(app(\Faker\Generator::class)->password);
        $data['balance'] = 0;

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
        ];
    }
}
