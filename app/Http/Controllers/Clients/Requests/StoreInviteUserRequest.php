<?php

namespace App\Http\Controllers\Clients\Requests;

use App\Http\Requests\FormRequest;
use Carbon\Carbon;

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
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function getFormData()
    {
        return [
            'password' => $this->request->get('password'),
            'email_verified_at' => Carbon::now()
        ];
    }
}
