<?php

namespace App\Http\Requests\Roles;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
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
