<?php

namespace App\Http\Controllers\Projects\Requests;


class StoreProjectTaskRequest extends UpdateProjectTaskRequest
{

    public function getFormData()
    {
        $data = parent::getFormData();

        return $data;
    }
}
