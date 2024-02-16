<?php

namespace App\Http\Requests\Matrix;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClaimCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'well_uuid' => ['required', 'string'],
            'new_value' => ['required', 'numeric', 'max:255'],
            'old_value' => ['required', 'numeric', 'max:255'],
            'category_id' => ['required', 'numeric', 'max:255'],
        ];
    }
}
