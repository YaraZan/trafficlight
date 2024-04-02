<?php

namespace App\Http\Requests\Matrix;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveWellRequest extends FormRequest
{
    public function rules()
    {
        return [
            'well_uuid' => ['required', 'string'],
            'well_id_conn' => ['required', 'numeric'],
            'roadheight' => ['numeric'],
            'comment' => ['string', 'max:255'],
        ];
    }
}
