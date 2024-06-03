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

    public function get(Request $request) {
        $query = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('Ngdu as ngdu', 'we.Ngdu_Id', '=', 'ngdu.Id')
            ->join('Category as ct', 'rc.Category_Id', '=', 'ct.Id')
            ->join('users as usr', 'rc.User_Id', '=', 'usr.id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select(
                'rc.*',
                'rfs.Id as RefClaimStatusId',
                'ngdu.Id as NgduId',
                'rfs.Id as RCStatusId',
                'we.Name as WellName',
                'we.public_id as WellPublicId',
                'rfs.RCStatusName as StatusName',
                'rfs.Color as StatusColor',
                'usr.name as UserName',
                'ct.CatName as CatName'
            )
            ->orderBy('rfs.Id')
            ->orderBy('rc.Dat', 'desc');

        if ($request->has('ngdus') && is_array($request->ngdus)) {
            $query->whereIn('we.Ngdu_Id', $request->ngdus);
        }

        if ($request->has('statuses') && is_array($request->statuses)) {
            $query->whereIn('rc.RefClaimStatus_Id', $request->statuses);
        }

        if (!Gate::allows('view-wells')) {
            $query->where('we.Ngdu_Id', '=', $request->user()->ngdu_id);
        }

        $query
        ->skip($request->skip)
        ->take($request->amount);

        $claims_data = $query->get();

        return response()->json($claims_data);
    }

}
