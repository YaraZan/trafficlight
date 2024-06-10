<?php

namespace App\Http\Controllers;

use App\Events\ClaimConsidered;
use App\Events\ClaimCreated;
use App\Events\ClaimDeclined;
use App\Models\RefClaim;
use App\Models\RefClaimStatus;
use App\Models\Well;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ClaimsController extends Controller
{
    public function view()
    {
        if (Gate::allows('control-wells')) {
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
                'rc.Id',
                'rc.OldValue',
                'rc.Value',
                'rc.Dat',
                'rfs.Id as RefClaimStatusId',
                'ngdu.Id as NgduId',
                'rfs.Id as RCStatusId',
                'we.Name as WellName',
                'we.public_id as WellPublicId',
                'rfs.RCStatusName as StatusName',
                'rfs.Color as StatusColor',
                'usr.name as UserName',
                'ct.CatName as CatName'
            );

        if ($request->has('ngdus') && is_array($request->ngdus)) {
            $query->whereIn('we.Ngdu_Id', $request->ngdus);
        }

        if ($request->has('statuses') && is_array($request->statuses)) {
            $query->whereIn('rc.RefClaimStatus_Id', $request->statuses);
        }

        if ($request->has('dates') && is_array($request->dates)) {

            $dates = $request->dates;

            if (count($dates) === 1) {

                $date = Carbon::parse($dates[0])->startOfDay();
                $query->whereDate('rc.Dat', '=', $date);
            } elseif (count($dates) === 2) {

                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate = Carbon::parse($dates[1])->endOfDay();
                $query->whereBetween('rc.Dat', [$startDate, $endDate]);
            }
        }

        if ($request->has('sorting')) {
            switch ($request->sorting) {
                case 'dat:asc':
                    $query->orderBy('rc.Dat', 'asc');
                    break;
                case 'dat:desc':
                    $query->orderBy('rc.Dat', 'desc');
                    break;
            }
        }

        if ($request->has('radio')) {
            switch ($request->radio) {
                case 'mine':
                    $query->where('rc.User_Id', '=', $request->user()->id);
                    break;
                case 'all':
                    break;
            }
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

    public function create(Request $request) {

        $request->validate([
            'well_id' => 'required',
            'category_id' => 'required',
            'old_value' => 'required',
            'new_value' => 'required',
        ]);

        $user = auth()->user();
        $well = Well::where('Id', $request->input('well_id'))->first();
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

        $refClaim = new RefClaim();
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

    public function delete(Request $request) {
        $request->validate([
            'claim_id' => ['required', 'integer'],
        ]);

        $claim_id = $request->input('claim_id');

        $claim = RefClaim::where('Id', '=', $claim_id)->first();

        $claim->delete();
    }

    public function consider(Request $request) {

        $request->validate([
            'claim_id' => ['required', 'integer'],
        ]);

        $claim_id = $request->input('claim_id');

        $claim = RefClaim::where('Id', '=', $claim_id)->first();

        $status = RefClaimStatus::where('RCStatusName', '=', 'Утверждено')->first();

        $claim->RefClaimStatus_Id = $status->Id;

        $claim->save();

        event(new ClaimConsidered($claim->Comment));
    }

    public function decline(Request $request) {

        $request->validate([
            'claim_id' => ['required', 'integer'],
        ]);

        $claim_id = $request->input('claim_id');

        $claim = RefClaim::where('Id', '=', $claim_id)->first();

        $status = RefClaimStatus::where('RCStatusName', '=', 'Отклонено')->first();

        $claim->RefClaimStatus_Id = $status->Id;

        $claim->save();

        event(new ClaimDeclined($claim->Comment));
    }

    public function getCurrentValues(Request $request) {
        $values = DB::table('ControlRef as cr')
        ->join('Well as we', 'cr.Well_Id', '=', 'we.Id')
        ->join('Category as ct', 'cr.Category_Id', '=', 'ct.Id')
        ->select('ct.Id as CategoryId',
            'cr.Ref1 as CurrentValue',
            'cr.armits_ref as ArmitsValue'
        )
        ->where('we.Id', '=', $request->well_id)
        ->where('ct.Id', '=', $request->category_id)
        ->first();

        $well = DB::table('WellAlarm as wa')
        ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
        ->select('wa.Alarm' . $request->category_id . ' as FactValue')
        ->where('we.Id', '=', $request->well_id)
        ->first();

        $values->FactValue = $well->FactValue;

        return response()->json($values);
    }

    public function getClaimDetails(Request $request)
    {
        $claim = RefClaim::with([
                'well',
                'well.ngdu',
                'user',
                'user.ngdu',
                'category',
                'status'
            ])
            ->where('Id', $request->claim_id)
            ->first();

        $response = [
            'claim' => [
                'Id' => $claim->Id,
                'WellName' => $claim->well->Name,
                'WellPublicId' => $claim->well->public_id,
                'NgduName' => $claim->well->ngdu->NgduName,
                'UserName' => $claim->user->name,
                'UserNgduName' => $claim->user->ngdu->NgduName,
                'OldValue' => $claim->OldValue,
                'Value' => $claim->Value,
                'Dat' => $claim->Dat,
                'CategoryNameShorted' => $claim->category->CatNameShorted,
                'CategoryName' => $claim->category->CatName,
                'StatusName' => $claim->status->RCStatusName,
                'StatusColor' => $claim->status->Color
            ],
            'permissions' => [
                'canDelete' => Gate::allows('delete-claim', $claim),
                'canConsider' => Gate::allows('consider-claim', $claim)
            ]
        ];

        return response()->json($response);
    }
}
