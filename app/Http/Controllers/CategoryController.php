<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function get(Request $request) {
        $query = DB::table('Category as c')
        ->select('c.Id as id', 'c.CatName as name', 'c.CatNameShorted as shortName');

        if ($request->has('writable') && $request->writable) {
            $query->where('c.is_writable', '=', 'true');
        }

        $claim_statuses_data = $query->get();

        return response()->json($claim_statuses_data);
    }

}
