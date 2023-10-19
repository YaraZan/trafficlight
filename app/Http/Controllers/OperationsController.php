<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OperationsController extends Controller
{
    public function index()
    {
        $operations_data = DB::table('WellAlarm as wa')
        ->join('Well as we', 'wa.Well_Id', '=', 'we.Id')
        ->join('Ngdu as ngdu', 'wa.Ngdu_Id', '=', 'ngdu.Id')
        ->join('Shop as sh', 'wa.Shop_Id', '=', 'sh.Id')
        ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
        ->join('WellState as st', 'wa.WState_Id', '=', 'st.Id')
        ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
        ->select([
            'we.public_id',
            'wa.Ngdu_Id',
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
        ->orderBy('wa.Stat1', 'desc')
        ->orderBy('wa.Stat2', 'desc')
        ->orderBy('wa.Stat3', 'desc')
        ->get();

        $ngdu_data = DB::table('Ngdu')->select('*')->get();

        return Inertia::render('Operations/Index', [
            'operations_data' => json_decode($operations_data),
            'ngdu_data' => json_decode($ngdu_data)
        ]);
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

        return Inertia::render('Operations/Detail', ['item' => $operation_data]);
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
        ->get();

        return Inertia::render('Operations/HourArch', [
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
        ->get();

        return Inertia::render('Operations/HourArchDetail', [
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
        ->get();

        return Inertia::render('Operations/AskStats', [
            'data' => $stat_data,
            'item' => $well_item
        ]);
    }
}
