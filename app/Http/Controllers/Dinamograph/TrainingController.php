<?php

namespace App\Http\Controllers\Dinamograph;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows('training')) {
            return Inertia::render('Dinamograph/Training', [
                'profile_data' => $request->user(),
            ]);
        }

        return Inertia::render('Errors/NotAuthorized');
    }
}
