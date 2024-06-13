<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Http\Requests\Matrix\MoveWellRequest;
use App\Models\Ngdu;
use App\Models\User;
use App\Models\Well;
use App\Models\WellAlarm;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WellController extends Controller
{
    public function index(Request $request)
    {
        $ngdu_data = Ngdu::with('shops')->get();

        $query = WellAlarm::with([
            'well',
            'well.plc',
            'well.hd',
            'ngdu',
            'shop',
            'state'
        ]);

        if (!Gate::allows('view-wells')) {
            $query->whereHas('well', function ($q) use ($request) {
                $q->where('Ngdu_Id', $request->user()->ngdu_id);
            });

            $ngdu_data = null;
        }

        $matrix_data = $query
            ->orderBy('Dif1', 'desc')
            ->orderBy('Dif2', 'desc')
            ->orderBy('Dif3', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'WellState_Id' => $item->WState_Id,
                    'public_id' => optional($item->well)->public_id,
                    'Ngdu_Id' => $item->Ngdu_Id,
                    'Well_Id' => $item->Well_Id,
                    'Shop_Id' => $item->Shop_Id,
                    'WState_Id' => $item->WState_Id,
                    'QnLost' => $item->lost,
                    'ShopName' => optional($item->shop)->ShopName,
                    'NgduName' => optional($item->ngdu)->NgduName,
                    'Name' => optional($item->well)->Name,
                    'WellName' => optional($item->well)->Name,
                    'WellState' => optional($item->state)->Name,
                    'PlcName' => optional($item->well->plc)->Name,
                    'HdName' => optional($item->well->hd)->HdName,
                    'Date' => $item->Date,
                    'SumErr' => $item->SumErr,
                    'Ask' => optional($item->well)->Ask,
                    'Connect' => $item->Connect,
                    'QnFak' => $item->qn_fak,
                    'Alarm1' => $item->Alarm1,
                    'Alarm2' => $item->Alarm2,
                    'Alarm3' => $item->Alarm3,
                    'Alarm4' => $item->Alarm4,
                    'Alarm6' => $item->Alarm6,
                    'Alarm7' => $item->Alarm7,
                    'Alarm8' => $item->Alarm8,
                    'Alarm9' => $item->Alarm9,
                    'Alarm10' => $item->Alarm10,
                    'Alarm11' => $item->Alarm11,
                    'Alarm12' => $item->Alarm12,
                    'Arm1' => $item->Arm1,
                    'Arm2' => $item->Arm2,
                    'Arm3' => $item->Arm3,
                    'Arm4' => $item->Arm4,
                    'Arm6' => $item->Arm6,
                    'Arm7' => $item->Arm7,
                    'Arm8' => $item->Arm8,
                    'Arm9' => $item->Arm9,
                    'Arm10' => $item->Arm10,
                    'Arm11' => $item->Arm11,
                    'Arm12' => $item->Arm12,
                    'Dif1' => $item->Dif1,
                    'Dif2' => $item->Dif2,
                    'Dif3' => $item->Dif3,
                    'Dif4' => $item->Dif4,
                    'Dif6' => $item->Dif6,
                    'Dif7' => $item->Dif7,
                    'Dif8' => $item->Dif8,
                    'Dif9' => $item->Dif9,
                    'Dif10' => $item->Dif10,
                    'Dif11' => $item->Dif11,
                    'Dif12' => $item->Dif12,
                    'Stat1' => $item->Stat1,
                    'Stat2' => $item->Stat2,
                    'Stat3' => $item->Stat3,
                    'Stat4' => $item->Stat4,
                    'Stat6' => $item->Stat6,
                    'Stat7' => $item->Stat7,
                    'Stat8' => $item->Stat8,
                    'Stat9' => $item->Stat9,
                    'Stat10' => $item->Stat10,
                    'Stat11' => $item->Stat11,
                    'Stat12' => $item->Stat12,
                    'Ref1' => $item->Ref1,
                    'Ref2' => $item->Ref2,
                    'Ref3' => $item->Ref3,
                    'Ref4' => $item->Ref4,
                    'Ref6' => $item->Ref6,
                    'Ref7' => $item->Ref7,
                    'Ref8' => $item->Ref8,
                    'Ref9' => $item->Ref9,
                    'Ref10' => $item->Ref10,
                    'Ref11' => $item->Ref11,
                    'Ref12' => $item->Ref12,
                    'Web' => optional($item->well)->Web,
                ];
            });

        return Inertia::render('Matrix/Index', [
            'data' => [
                'matrix_data' => json_decode($matrix_data),
                'ngdu_data' => json_decode($ngdu_data),
            ]
        ]);
    }

    public function show($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();

        if (Gate::allows('view-wells') || Gate::allows('view-well', $well)) {
            $well_alarm = WellAlarm::with([
                'well',
                'ngdu',
                'shop',
                'well.plc',
                'well.hd',
                'state'
            ])
            ->whereHas('well', function ($query) use ($well_uuid) {
                $query->where('public_id', $well_uuid);
            })
            ->orderBy('Dif1', 'desc')
            ->orderBy('Dif2', 'desc')
            ->orderBy('Dif3', 'desc')
            ->first();

            if ($well_alarm) {
                $well_data = [
                    'WellState_Id' => $well_alarm->WState_Id,
                    'public_id' => optional($well_alarm->well)->public_id,
                    'Ngdu_Id' => $well_alarm->Ngdu_Id,
                    'Well_Id' => $well_alarm->Well_Id,
                    'Shop_Id' => $well_alarm->Shop_Id,
                    'WState_Id' => $well_alarm->WState_Id,
                    'QnLost' => $well_alarm->lost,
                    'ShopName' => optional($well_alarm->shop)->ShopName,
                    'NgduName' => optional($well_alarm->ngdu)->NgduName,
                    'Name' => optional($well_alarm->well)->Name,
                    'WellName' => optional($well_alarm->well)->Name,
                    'WellState' => optional($well_alarm->state)->Name,
                    'PlcName' => optional($well_alarm->well->plc)->Name,
                    'HdName' => optional($well_alarm->well->hd)->HdName,
                    'Date' => $well_alarm->Date,
                    'SumErr' => $well_alarm->SumErr,
                    'Ask' => optional($well_alarm->well)->Ask,
                    'Connect' => $well_alarm->Connect,
                    'QnFak' => $well_alarm->qn_fak,
                    'Alarm1' => $well_alarm->Alarm1,
                    'Alarm2' => $well_alarm->Alarm2,
                    'Alarm3' => $well_alarm->Alarm3,
                    'Alarm4' => $well_alarm->Alarm4,
                    'Alarm6' => $well_alarm->Alarm6,
                    'Alarm7' => $well_alarm->Alarm7,
                    'Alarm8' => $well_alarm->Alarm8,
                    'Alarm9' => $well_alarm->Alarm9,
                    'Alarm10' => $well_alarm->Alarm10,
                    'Alarm11' => $well_alarm->Alarm11,
                    'Alarm12' => $well_alarm->Alarm12,
                    'Arm1' => $well_alarm->Arm1,
                    'Arm2' => $well_alarm->Arm2,
                    'Arm3' => $well_alarm->Arm3,
                    'Arm4' => $well_alarm->Arm4,
                    'Arm6' => $well_alarm->Arm6,
                    'Arm7' => $well_alarm->Arm7,
                    'Arm8' => $well_alarm->Arm8,
                    'Arm9' => $well_alarm->Arm9,
                    'Arm10' => $well_alarm->Arm10,
                    'Arm11' => $well_alarm->Arm11,
                    'Arm12' => $well_alarm->Arm12,
                    'Dif1' => $well_alarm->Dif1,
                    'Dif2' => $well_alarm->Dif2,
                    'Dif3' => $well_alarm->Dif3,
                    'Dif4' => $well_alarm->Dif4,
                    'Dif6' => $well_alarm->Dif6,
                    'Dif7' => $well_alarm->Dif7,
                    'Dif8' => $well_alarm->Dif8,
                    'Dif9' => $well_alarm->Dif9,
                    'Dif10' => $well_alarm->Dif10,
                    'Dif11' => $well_alarm->Dif11,
                    'Dif12' => $well_alarm->Dif12,
                    'Stat1' => $well_alarm->Stat1,
                    'Stat2' => $well_alarm->Stat2,
                    'Stat3' => $well_alarm->Stat3,
                    'Stat4' => $well_alarm->Stat4,
                    'Stat6' => $well_alarm->Stat6,
                    'Stat7' => $well_alarm->Stat7,
                    'Stat8' => $well_alarm->Stat8,
                    'Stat9' => $well_alarm->Stat9,
                    'Stat10' => $well_alarm->Stat10,
                    'Stat11' => $well_alarm->Stat11,
                    'Stat12' => $well_alarm->Stat12,
                    'Ref1' => $well_alarm->Ref1,
                    'Ref2' => $well_alarm->Ref2,
                    'Ref3' => $well_alarm->Ref3,
                    'Ref4' => $well_alarm->Ref4,
                    'Ref6' => $well_alarm->Ref6,
                    'Ref7' => $well_alarm->Ref7,
                    'Ref8' => $well_alarm->Ref8,
                    'Ref9' => $well_alarm->Ref9,
                    'Ref10' => $well_alarm->Ref10,
                    'Ref11' => $well_alarm->Ref11,
                    'Ref12' => $well_alarm->Ref12,
                    'Web' => optional($well_alarm->well)->Web,
                ];

                return Inertia::render('Matrix/Detail', ['item' => $well_data]);
            }

            return Inertia::render('Errors/NotAuthorized');
        }
    }

    public function all() {
        $wells = DB::table('Well as we')
        ->join('Ngdu as n', 'we.Ngdu_Id', '=', 'n.Id')
        ->select('we.*', 'n.NgduName as NgduName', 'we.Name as WellName', 'we.Id as WellId')->get();

        return response()->json($wells);
    }

    public function get(Request $request) {
        $query = DB::table('Well as we')
        ->join('Ngdu as n', 'we.Ngdu_Id', '=', 'n.Id')
        ->select('we.Id as id', 'n.NgduName as ngduName', 'we.Name as name');

        if ($request->has('name') && isset($request->name)) {
            $query->whereRaw('UPPER("we"."Name") LIKE UPPER(?)', ['%' . $request->name . '%']);
        }

        if (!Gate::allows('view-wells')) {
            $query->where('we.Ngdu_Id', '=', $request->user()->ngdu_id);
        }

        $query
        ->skip($request->skip)
        ->take($request->amount);

        $well_data = $query->get();

        return response()->json($well_data);
    }

}
