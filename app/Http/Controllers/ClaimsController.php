<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ClaimsController extends Controller
{
    public function view()
    {
        if (Gate::allows('view-wells') || Gate::allows('control-wells')) {
            return Inertia::render('Claims/Index');
        }
        return Inertia::render('Errors/NotAuthorized');
    }

    public function all(Request $request) {
        if (Gate::allows('view-wells')) {
            $claims_data = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('Category as ct', 'rc.Category_Id', '=', 'ct.Id')
            ->join('users as usr', 'rc.User_Id', '=', 'usr.id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select(
                'rc.*',
                'rfs.Id as RCStatusId',
                'we.Name as WellName',
                'rfs.RCStatusName as StatusName',
                'usr.name as UserName',
                'ct.CatName as CatName',
            )
            ->orderBy('rfs.Id')
            ->orderBy('rc.Dat', 'desc')
            ->get();
        } else {
            $claims_data = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('Category as ct', 'rc.Category_Id', '=', 'ct.Id')
            ->join('users as usr', 'rc.User_Id', '=', 'usr.id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select(
                'rc.*',
                'rfs.Id as RCStatusId',
                'we.Name as WellName',
                'rfs.RCStatusName as StatusName',
                'usr.name as UserName',
                'ct.CatName as CatName',
            )
            ->where('we.Ngdu_Id', '=', $request->user()->ngdu_id)
            ->orderBy('rfs.Id')
            ->orderBy('rc.Dat', 'desc')
            ->get();
        }

        return response()->json($claims_data);
    }
}
