<?php

namespace App\Http\Controllers\Projects\Requests;

use Carbon\Carbon;

class StoreProjectUserRequest extends UpdateProjectUserRequest
{

    public function getFormData()
    {
        $data = parent::getFormData();

        return $data;
    }
}
