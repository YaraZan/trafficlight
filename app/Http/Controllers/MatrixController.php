<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WellAlarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MatrixController extends Controller
{
    public function index()
    {
        if (Gate::allows('view-any', User::class)) {
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
                    'we.Web',
                ])
                ->orderBy('wa.Dif1', 'desc')
                ->orderBy('wa.Dif2', 'desc')
                ->orderBy('wa.Dif3', 'desc')
                ->get();

                $ngdu_data = DB::table('Ngdu')->select('*')->get();
        } else {
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
                    'we.Web',
                ])
                ->orderBy('wa.Dif1', 'desc')
                ->orderBy('wa.Dif2', 'desc')
                ->orderBy('wa.Dif3', 'desc')
                ->where('wa.Ngdu_Id', '=', $user->ngdu_id)
                ->get();

                $ngdu_data = null;
        }


        $shop_data = DB::table('Shop')->select('*')->get();

        return Inertia::render('Matrix/Index', ['data' => [
            'matrix_data' => json_decode($matrix_data),
            'ngdu_data' => json_decode($ngdu_data),
            'shop_data' => json_decode($shop_data),
        ]]);
    }

    public function detail($operation_uuid)
    {
        $operation_data = DB::table('WellAlarm as wa')
        ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
        ->join('Ngdu as ngdu', 'wa.Ngdu_Id', '=', 'ngdu.Id')
        ->join('Shop as sh', 'wa.Shop_Id', '=', 'sh.Id')
        ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
        ->join('WellState as st', 'wa.WState_Id', '=', 'st.Id')
        ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
        ->orderBy('wa.Ngdu_Id')
        ->orderBy('wa.Id')
        ->select([
            'we.public_id',
            'ngdu.NgduName as NgduName',
            'pl.Name as PlcName',
            'sh.ShopName as ShopName',
            'h.Hdname as HdName',
            'we.Name',
            'we.Ask',
            'wa.Connect',
            'we.Web',
            'wa.Dif1',
            'wa.Dif2',
            'wa.Dif3',
        ])
        ->where('we.public_id', '=', $operation_uuid)
        ->first();

        return Inertia::render('Matrix/Detail', ['item' => $operation_data]);
    }

    public function hourArch($operation_uuid) 
    {
        $well_item = DB::table('Well')->select('Id', 'public_id', 'Name',)->where('public_id', '=', $operation_uuid)
        ->first();

        $head_hour_data = DB::table('HeadHour as hh')
        ->join('Well as we', 'hh.Well_Id', '=', 'we.Id')
        ->select([
            'hh.Id',
            'hh.public_id',
            'hh.Well_Id',
            'hh.SumErr',
            'hh.Date',
            'hh.Debit'])
        ->where('hh.Well_Id', '=', $well_item->Id)
        ->orderBy('hh.Date', 'desc')
        ->take(1500)
        ->get();

        return Inertia::render('Matrix/HourArch', [
            'data' => $head_hour_data,
            'item' => $well_item
        ]);
    }

    public function hourArchDetail($operation_uuid, $head_hour_uuid) 
    {
        $well_item = DB::table('Well')->select('Id', 'public_id', 'Name',)->where('public_id', '=', $operation_uuid)
        ->first();

        $head_hour_item = DB::table('HeadHour')->select('Id', 'public_id', 'Date')->where('public_id', '=', $head_hour_uuid)
        ->first();

        $hour_arch_data = DB::table('HourArch as ha')
        ->join('Category as cat', 'ha.Category_Id', '=', 'cat.Id')
        ->join('Well as we', 'ha.Well_Id', '=', 'we.Id')
        ->join('HeadHour as hh', 'ha.HeadHour_Id', '=', 'hh.Id')
        ->select([
            'ha.Id',
            'ha.HeadHour_Id',
            'ha.Category_Id',
            'ha.Well_Id',
            'cat.CatName as CatName',
            'ha.Date',
            'ha.Ref1',
            'ha.Cur1',
            'ha.Res1',
            'ha.Err1',
            'ha.Stat1',
            'ha.Ref2',
            'ha.Cur2',
            'ha.Res2',
            'ha.Err2',
            'ha.Stat2',
            'ha.Ref3',
            'ha.Cur3',
            'ha.Res3',
            'ha.Err3',
            'ha.Stat3',
        ])
        ->where('ha.HeadHour_Id', '=', $head_hour_item->Id)
        ->orderBy('ha.Date', 'desc')
        ->take(1500)
        ->get();

        return Inertia::render('Matrix/HourArchDetail', [
            'data' => $hour_arch_data,
            'well_item' => $well_item,
            'head_hour_item' => $head_hour_item,
        ]);
    }


    public function askStats($operation_uuid)
    {
        $well_item = DB::table('Well')->select('Id', 'public_id', 'Name')->where('public_id', '=', $operation_uuid)->first();

        $stat_data = DB::table('PingLog as pl')
        ->join('Well as we', 'pl.Well_Id', '=', 'we.Id')
        ->select([
            'pl.Id',
            'pl.Well_Id',
            'pl.Date',
            'pl.Quality',
            'pl.AskLong'
        ])
        ->where('pl.Well_Id', '=', $well_item->Id)
        ->orderBy('pl.Date', 'desc')
        ->take(1500)
        ->get();

        return Inertia::render('Matrix/AskStats', [
            'data' => $stat_data,
            'item' => $well_item
        ]);
    }
}
