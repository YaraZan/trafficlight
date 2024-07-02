<?php

namespace App\Http\Requests\Users;

use App\Models\User;
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
            'public_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore(User::where('public_id', '=', $this->public_id)->first())],
            'role_id' => ['required', 'integer'],
            'ngdu_id' => ['required', 'integer'],
        ];
    }
}
