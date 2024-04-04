<?php

namespace App\Http\Controllers\Matrix;

use App\Events\ClaimCreated;
use App\Events\ClaimTracked;
use App\Http\Controllers\Controller;
use App\Http\Requests\Matrix\MoveWellRequest;
use App\Models\WellClaim;
use App\Models\User;
use App\Models\Well;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoveWellController extends Controller
{
    public function allByWell($well_uuid) {
        return DB::table('well_claim_executing as wce')
        ->join('WellClaim as wc', 'wce.well_claim_id', '=', 'wc.id')
        ->join('WellClaimStatus as wcs', 'wce.wcs_id', '=', 'wcs.Id')
        ->join('users as u', 'wc.user_id', '=', 'u.id')
        ->join('Well as w', 'wc.well_id_disconn', '=', 'w.Id')
        ->select(
            'wce.id',
            'wcs.WCStatusName as StatusName',
            'u.name as UserName',
            'wc.well_id_conn as ArmitsID',
            'wce.comment as Comment',
            'wce.dat',
        )
        ->where('w.public_id', '=', $well_uuid)
        ->orderBy('wce.dat', 'DESC')->get();
    }

    public function allByUser($well_uuid) {
        return DB::table('WellClaim as wc')
        ->join('users as u', 'wc.user_id', '=', 'u.id')
        ->join('Well as w', 'wc.well_id_disconn', '=', 'w.Id')
        ->join('WellClaimStatus as wcs', 'wc.wcs_id', '=', 'wcs.Id')
        ->select(
            'wc.id',
            'wcs.WCStatusName as StatusName',
            'u.name as UserName',
            'wc.well_id_conn as ArmitsID',
            'wc.dat',
        )
        ->where('wc.user_id', '=', auth()->user()->id)
        ->where('w.public_id', '=', $well_uuid)
        ->orderBy('wc.dat', 'DESC')->get();
    }

    public function create(MoveWellRequest $request) {
        $user = auth()->user();

        $well_from = Well::where('public_id', $request->input('well_uuid'))->first();
        $well_claim_status = DB::table('WellClaimStatus')->where('WCStatusName', '=', 'На рассмотрении')->first();

        $refClaim = new WellClaim();
        $refClaim->well_id_disconn = $well_from->Id;
        $refClaim->well_id_conn = $request->input('well_id_conn');
        $refClaim->user_id = $user->id;
        $refClaim->wcs_id = $well_claim_status->Id;
        $refClaim->comment = $request->input('comment') ? $request->input('comment') : null;
        $refClaim->roadheight = $request->input('roadheight') ? $request->input('roadheight') : 2000;
        $refClaim->dat = date('Y-m-d H:i:s.u');
        $refClaim->save();
    }

    public function delete(Request $request) {
        $request->validate([
            'claim_id' => ['required', 'integer'],
        ]);

        $claim_id = $request->input('claim_id');

        $claim = WellClaim::where('id', '=', $claim_id)->first();

        $claim->delete();
    }
}
