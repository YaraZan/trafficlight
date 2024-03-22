<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\Ngdu;
use App\Models\User;
use App\Models\Well;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WellController extends Controller
{
    public function index()
    {
        if (Gate::allows('view-wells')) {
            $matrix_data = DB::table('WellAlarm as wa')
                ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
                ->join('Ngdu as ngdu', 'wa.Ngdu_Id', '=', 'ngdu.Id')
                ->join('Shop as sh', 'wa.Shop_Id', '=', 'sh.Id')
                ->join('WellState as st', 'wa.WState_Id', '=', 'st.Id')
                ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
                ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
                ->select([
                    'st.Id as WellState_Id',
                    'we.public_id',
                    'wa.Ngdu_Id',
                    'wa.Well_Id',
                    'wa.Shop_Id',
                    'wa.WState_Id',
                    'wa.lost as QnLost',
                    'sh.ShopName',
                    'ngdu.NgduName as NgduName',
                    'we.Name',
                    'we.Name as WellName',
                    'st.Name as WellState',
                    'pl.Name as PlcName',
                    'sh.ShopName as ShopName',
                    'h.Hdname as HdName',
                    "wa.Date",
                    'wa.SumErr',
                    'we.Ask',
                    "wa.Connect",
                    'wa.qn_fak as QnFak',
                    'wa.Alarm1',
                    'wa.Alarm2',
                    'wa.Alarm3',
                    'wa.Alarm4',
                    'wa.Alarm6',
                    'wa.Alarm7',
                    'wa.Alarm8',
                    'wa.Alarm9',
                    'wa.Alarm10',
                    'wa.Alarm11',
                    'wa.Alarm12',
                    'wa.Arm1',
                    'wa.Arm2',
                    'wa.Arm3',
                    'wa.Arm4',
                    'wa.Arm6',
                    'wa.Arm7',
                    'wa.Arm8',
                    'wa.Arm9',
                    'wa.Arm10',
                    'wa.Arm11',
                    'wa.Arm12',
                    'wa.Dif1',
                    'wa.Dif2',
                    'wa.Dif3',
                    'wa.Dif4',
                    'wa.Dif6',
                    'wa.Dif7',
                    'wa.Dif8',
                    'wa.Dif9',
                    'wa.Dif10',
                    'wa.Dif11',
                    'wa.Dif12',
                    'wa.Stat1',
                    'wa.Stat2',
                    'wa.Stat3',
                    'wa.Stat4',
                    'wa.Stat6',
                    'wa.Stat7',
                    'wa.Stat8',
                    'wa.Stat9',
                    'wa.Stat10',
                    'wa.Stat11',
                    'wa.Stat12',
                    'wa.Ref1',
                    'wa.Ref2',
                    'wa.Ref3',
                    'wa.Ref4',
                    'wa.Ref6',
                    'wa.Ref7',
                    'wa.Ref8',
                    'wa.Ref9',
                    'wa.Ref10',
                    'wa.Ref11',
                    'wa.Ref12',
                    'we.Web as Web',
                ])
                ->orderBy('wa.Dif1', 'desc')
                ->orderBy('wa.Dif2', 'desc')
                ->orderBy('wa.Dif3', 'desc')
                ->get();

                $ngdu_data = Ngdu::with('shops')->get();
        }
        else {
            $user = auth()->user();
            $matrix_data = DB::table('WellAlarm as wa')
                ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
                ->join('Ngdu as ngdu', 'wa.Ngdu_Id', '=', 'ngdu.Id')
                ->join('Shop as sh', 'wa.Shop_Id', '=', 'sh.Id')
                ->join('WellState as st', 'wa.WState_Id', '=', 'st.Id')
                ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
                ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
                ->select([
                    'we.public_id',
                    'wa.Ngdu_Id',
                    'wa.Well_Id',
                    'wa.Shop_Id',
                    'wa.WState_Id',
                    'sh.ShopName',
                    'ngdu.NgduName as NgduName',
                    'we.Name',
                    'we.Name as WellName',
                    'st.Name as WellState',
                    'pl.Name as PlcName',
                    'sh.ShopName as ShopName',
                    'h.Hdname as HdName',
                    "wa.Date",
                    'wa.SumErr',
                    'we.Ask',
                    "wa.Connect",
                    'wa.Alarm1',
                    'wa.Alarm2',
                    'wa.Alarm3',
                    'wa.Alarm4',
                    'wa.Alarm6',
                    'wa.Alarm7',
                    'wa.Alarm8',
                    'wa.Alarm9',
                    'wa.Alarm11',
                    'wa.Alarm12',
                    'wa.Dif1',
                    'wa.Dif2',
                    'wa.Dif3',
                    'wa.Dif4',
                    'wa.Dif6',
                    'wa.Dif7',
                    'wa.Dif8',
                    'wa.Dif9',
                    'wa.Dif11',
                    'wa.Dif12',
                    'wa.Stat1',
                    'wa.Stat2',
                    'wa.Stat3',
                    'wa.Stat4',
                    'wa.Stat6',
                    'wa.Stat7',
                    'wa.Stat8',
                    'wa.Stat9',
                    'wa.Stat11',
                    'wa.Stat12',
                    'wa.Ref1',
                    'wa.Ref2',
                    'wa.Ref3',
                    'wa.Ref4',
                    'wa.Ref6',
                    'wa.Ref7',
                    'wa.Ref8',
                    'wa.Ref9',
                    'wa.Ref11',
                    'wa.Ref12',
                    'we.Web as Web',
                ])
                ->orderBy('wa.Dif1', 'desc')
                ->orderBy('wa.Dif2', 'desc')
                ->orderBy('wa.Dif3', 'desc')
                ->where('wa.Ngdu_Id', '=', $user->ngdu_id)
                ->get();

                $ngdu_data = null;
        }

        return Inertia::render('Matrix/Index', ['data' => [
            'matrix_data' => json_decode($matrix_data),
            'ngdu_data' => json_decode($ngdu_data),
        ]]);
    }

    public function show($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();

        if (Gate::allows('view-wells') || Gate::allows('view-well', $well)) {
            $well_data = DB::table('WellAlarm as wa')
            ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
            ->join('Ngdu as ngdu', 'wa.Ngdu_Id', '=', 'ngdu.Id')
            ->join('Shop as sh', 'wa.Shop_Id', '=', 'sh.Id')
            ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
            ->join('WellState as st', 'wa.WState_Id', '=', 'st.Id')
            ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
            ->select([
                'st.Id as WellState_Id',
                'we.public_id',
                'wa.Ngdu_Id',
                'wa.Well_Id',
                'wa.Shop_Id',
                'wa.WState_Id',
                'wa.lost as QnLost',
                'sh.ShopName',
                'ngdu.NgduName as NgduName',
                'we.Name',
                'we.Name as WellName',
                'st.Name as WellState',
                'pl.Name as PlcName',
                'sh.ShopName as ShopName',
                'h.Hdname as HdName',
                "wa.Date",
                'wa.SumErr',
                'we.Ask',
                "wa.Connect",
                'wa.qn_fak as QnFak',
                'wa.Alarm1',
                'wa.Alarm2',
                'wa.Alarm3',
                'wa.Alarm4',
                'wa.Alarm6',
                'wa.Alarm7',
                'wa.Alarm8',
                'wa.Alarm9',
                'wa.Alarm10',
                'wa.Alarm11',
                'wa.Alarm12',
                'wa.Arm1',
                'wa.Arm2',
                'wa.Arm3',
                'wa.Arm4',
                'wa.Arm6',
                'wa.Arm7',
                'wa.Arm8',
                'wa.Arm9',
                'wa.Arm10',
                'wa.Arm11',
                'wa.Arm12',
                'wa.Dif1',
                'wa.Dif2',
                'wa.Dif3',
                'wa.Dif4',
                'wa.Dif6',
                'wa.Dif7',
                'wa.Dif8',
                'wa.Dif9',
                'wa.Dif10',
                'wa.Dif11',
                'wa.Dif12',
                'wa.Stat1',
                'wa.Stat2',
                'wa.Stat3',
                'wa.Stat4',
                'wa.Stat6',
                'wa.Stat7',
                'wa.Stat8',
                'wa.Stat9',
                'wa.Stat10',
                'wa.Stat11',
                'wa.Stat12',
                'wa.Ref1',
                'wa.Ref2',
                'wa.Ref3',
                'wa.Ref4',
                'wa.Ref6',
                'wa.Ref7',
                'wa.Ref8',
                'wa.Ref9',
                'wa.Ref10',
                'wa.Ref11',
                'wa.Ref12',
                'we.Web as Web',
            ])
            ->orderBy('wa.Dif1', 'desc')
            ->orderBy('wa.Dif2', 'desc')
            ->orderBy('wa.Dif3', 'desc')
            ->where('we.public_id', '=', $well_uuid)
            ->first();

//            if (Gate::allows('control-wells')) {
//                return Inertia::render('Matrix/DetailControl', ['item' => $well_data]);
//            }

            return Inertia::render('Matrix/Detail', ['item' => $well_data]);
        }

        return Inertia::render('Errors/NotAuthorized');
    }
}
