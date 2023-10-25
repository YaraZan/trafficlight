<?php

namespace App\Http\Requests\Users;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
            'name' => ['required', 'string', 'max:255', Rule::unique(Role::class)->ignore(Role::find($this->id))],
            'can_edit' => 'required',
            'can_view_all' => 'required',
        ];
    }
}
