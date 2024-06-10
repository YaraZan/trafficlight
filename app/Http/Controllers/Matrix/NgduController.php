<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class NgduController extends Controller
{
    public function all()
    {
        $ngdu = DB::table('Ngdu as n')->select('n.Id as id', 'n.NgduName as name')->get();
        return response()->json($ngdu);
    }
}
