<?php

namespace App\Http\Controllers\Matrix;

use App\Events\ClaimCreated;
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
        $categories = DB::table('Category')
            ->select('Id', 'CatName', 'CatNameShorted')
            ->orderBy('Id')
            ->get();

        foreach ($categories as $category) {
            $alarmColumnName = 'Alarm' . $category->Id;
            $refColumnName = 'Ref' . $category->Id;
            $stateColumnName = 'Stat' . $category->Id;

            $well_data = DB::table('WellAlarm as wa')
                ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
                ->where('we.public_id', '=', $well_uuid)
                ->select('wa.' . $alarmColumnName, 'wa.' . $refColumnName, 'wa.' . $stateColumnName)
                ->first();

            $category->current_value = $well_data->$alarmColumnName;
            $category->setpoint_value = $well_data->$refColumnName;
            $category->state_value = $well_data->$stateColumnName;
        }

        return response()->json($categories);
    }

    public function getUserClaims($well_uuid)
    {
        $user = auth()->user();

        $user_claims = DB::table('RefClaim as rc')
            ->join('Well as we', 'rc.Well_Id', '=', 'we.Id')
            ->join('RefClaimStatus as rfs', 'rc.RefClaimStatus_Id', '=', 'rfs.Id')
            ->select('rc.*', 'rfs.RCStatusName as StatusName')
            ->where('User_Id', '=', $user->id)
            ->where('we.public_id', '=', $well_uuid)
            ->get();

        return response()->json($user_claims);
    }

    public function createNewClaim(ClaimCreateRequest $request)
    {
        $user = auth()->user();

        $well = Well::where('public_id', $request->input('well_uuid'))->first();

        $category = DB::table('Category')->
        where('Id', '=', $request->input('category_id'))->first();

        $comment =
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
