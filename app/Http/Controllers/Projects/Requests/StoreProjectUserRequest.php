<?php

namespace App\Http\Controllers\Projects\Requests;

class StoreProjectUserRequest extends UpdateProjectUserRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['user_id'] = ['required', 'exists:users,id'];

        return $rules;
    }

    public function getFormData()
    {
        $data = parent::getFormData();

        return $data;
    }
}
