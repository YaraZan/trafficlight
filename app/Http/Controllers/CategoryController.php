<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function all() {
        $claim_statuses_data = DB::table('Category as c')
        ->select('c.Id as id', 'c.CatName as name', 'c.CatNameShorted as shortName')
        ->where('c.is_writable', '=', 'true')
        ->get();

        return response()->json($claim_statuses_data);
    }

}
