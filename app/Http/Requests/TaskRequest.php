<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'user_id' => ['required', 'integer'],
            'project_id' => ['required', 'integer'],
            'status' => ['required', 'string'],
        ];
    }
}
