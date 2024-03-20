<?php

namespace App\Http\Controllers\Matrix;

use App\Events\ClaimCreated;
use App\Events\ClaimTracked;
use App\Http\Controllers\Controller;
use App\Http\Requests\Matrix\ClaimCreateRequest;
use App\Http\Requests\Matrix\ClaimDeleteRequest;
use App\Models\RefClaim;
use App\Models\User;
use App\Models\Well;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class ControlController extends Controller
{
    public function index($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();

        if ((Gate::allows('view-wells') || Gate::allows('view-well', $well)) && Gate::allows('control-wells')) {

            $well_item = DB::table('Well')->select('Id', 'public_id', 'Name')->where('public_id', '=', $well_uuid)->first();

            return Inertia::render('Matrix/Control', [
                'item' => $well_item
            ]);
        }

        return Inertia::render('Errors/NotAuthorized');

    }

    public function getCategoriesAndValues($well_uuid)
    {
        $categories = DB::table('ControlRef as cr')
            ->join('Well as we', 'cr.Well_Id', '=', 'we.Id')
            ->join('Category as ct', 'cr.Category_Id', '=', 'ct.Id')
            ->select('ct.Id as CategoryId',
                'ct.CatName as CatName',
                'ct.CatNameShorted as CatNameShorted',
                'ct.is_writable as IsWritable',
                'cr.Ref1 as CurrentValue',
                'cr.armits_ref as ArmitsValue'
            )
            ->where('we.public_id', '=', $well_uuid)
            ->orderBy('IsWritable', 'desc')
            ->orderBy('Category_Id')
            ->get();

        return response()->json($categories);
    }

    public function getCategoriesAndFactValues($well_uuid)
    {
        $categories = DB::table('ControlRef as cr')
            ->join('Well as we', 'cr.Well_Id', '=', 'we.Id')
            ->join('WellAlarm as wa', 'we.Id', '=', 'wa.Well_Id')
            ->join('Category as ct', 'cr.Category_Id', '=', 'ct.Id')
            ->select('ct.Id as CategoryId',
                'ct.CatName as CatName',
                'ct.CatNameShorted as CatNameShorted',
                'wa.Id as WellAlarmId',
                'ct.is_writable as IsWritable',
                'cr.Ref1 as CurrentValue',
                'cr.armits_ref as ArmitsValue'
            )
            ->where('we.public_id', '=', $well_uuid)
            ->orderBy('IsWritable', 'desc')
            ->orderBy('Category_Id')
            ->get();

        foreach ($categories as $category) {
            $well_item =
                DB::table('WellAlarm as wa')
                    ->where('wa.Id', '=', $category->WellAlarmId)
                    ->select('wa.Alarm' . $category->CategoryId . ' as FactValue')
                    ->first();

            $category->FactValue = $well_item->FactValue;
        }

        return response()->json($categories);
    }

    public function getUserClaims($well_uuid)
    {
        $user = auth()->user();

        $user_claims = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('Category as ct', 'rc.Category_Id', '=', 'ct.Id')
            ->join('users as usr', 'rc.User_Id', '=', 'usr.id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select(
                'rc.*',
                'rfs.RCStatusName as StatusName',
                'usr.name as UserName',
                'ct.CatName as CatName'
            )
            ->where('User_Id', '=', $user->id)
            ->where('we.public_id', '=', $well_uuid)
            ->get();

        return response()->json($user_claims);
    }

    public function getWellClaims($well_uuid)
    {
        $well_claims = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('Category as ct', 'rc.Category_Id', '=', 'ct.Id')
            ->join('users as usr', 'rc.User_Id', '=', 'usr.id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select(
                'rc.*',
                'rfs.RCStatusName as StatusName',
                'usr.name as UserName',
                'ct.CatName as CatName'
            )
            ->where('we.public_id', '=', $well_uuid)
            ->get();

        return response()->json($well_claims);
    }

    public function getWellUntrackedClaims($well_uuid)
    {
        $well_claims = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('Category as ct', 'rc.Category_Id', '=', 'ct.Id')
            ->join('users as usr', 'rc.User_Id', '=', 'usr.id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select(
                'rc.*',
                'rfs.RCStatusName as StatusName',
                'usr.name as UserName',
                'ct.CatName as CatName'
            )
            ->where('we.public_id', '=', $well_uuid)
            ->where('rfs.Id', '=', 1)
            ->get();

        return response()->json($well_claims);
    }

    public function trackClaim(Request $request)
    {
        $claim_id = $request->input('claim_id');

        $claim_status = DB::table('RefClaimStatus as rcs')
            ->where('RCStatusName', '=', 'Утверждено')->first();

        $claim = RefClaim::where('Id', '=', $claim_id)->first();

        $claim->RefClaimStatus_Id = $claim_status->Id;

        $claim->save();

        event(new ClaimTracked($claim->Comment));
    }

    public function createNewClaim(ClaimCreateRequest $request)
    {
        $user = auth()->user();

        $well = Well::where('public_id', $request->input('well_uuid'))->first();

        $category = DB::table('Category')->
        where('Id', '=', $request->input('category_id'))->first();

        $comment =
            $well->Name .
            '-' .
            $category->CatName .
            ': ' .
            $request->input('old_value') .
            ' -> ' .
            $request->input('new_value');

        $refClaim = new RefClaim;
        $refClaim->Well_Id = $well->Id;
        $refClaim->User_Id = $user->id;
        $refClaim->Comment = $comment;
        $refClaim->Dat = date('Y-m-d H:i:s.u');
        $refClaim->Category_Id = $request->input('category_id');
        $refClaim->RefClaimStatus_Id = 1;
        $refClaim->OldValue = $request->input('old_value');
        $refClaim->Value = $request->input('new_value');
        $refClaim->save();

        event(new ClaimCreated($comment));
    }

    public function deleteClaim(Request $request) {

        $request->validate([
            'claim_id' => ['required', 'integer'],
        ]);

        $claim_id = $request->input('claim_id');

        $claim = RefClaim::where('Id', '=', $claim_id)->first();

        $claim->delete();

    }
}
