<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ClaimStatusController extends Controller
{

    public function all() {
        $claim_statuses_data = DB::table('RefClaimStatus as rcs')
        ->select('rcs.Id as id', 'rcs.RCStatusName as name', 'rcs.Color as color')
        ->get();

        return response()->json($claim_statuses_data);
    }

}
