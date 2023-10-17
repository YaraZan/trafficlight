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
        $operations_data = DB::table('Well as we')
        ->join('WellState as st', 'we.WellState_Id', '=', 'st.Id')
        ->join('Ngdu as ngdu', 'we.Ngdu_Id', '=', 'ngdu.Id')
        ->join('Shop as sh', 'we.Shop_Id', '=', 'sh.Id')
        ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
        ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
        ->join('Map as mp', 'we.Map_Id', '=', 'mp.Id')
        ->join('Uplc as upl', 'we.Uplc_Id', '=', 'upl.Id')
        ->orderBy('we.Ngdu_Id')
        ->orderBy('we.Id')
        ->select([
            'we.Id',
            'we.public_id',
            'we.Ngdu_Id',
            'we.WellState_Id',
            'we.Shop_Id',
            'we.Plc_Id',
            'we.Hd_Id',
            'we.Map_Id',
            'we.Uplc_Id',
            'ngdu.NgduName as NgduName',
            'pl.Name as PlcName',
            'sh.ShopName as ShopName',
            'h.Hdname as HdName',
            'we.Name',
            'we.FlDiagnost',
            'we.Ask',
            'we.Connect',
            'we.Web',
        ])
        ->get();

        $ngdu_data = DB::table('Ngdu')->select('*')->get();

        return Inertia::render('Operations/Index', ['data' => [
            'operations_data' => json_decode($operations_data),
            'ngdu_data' => json_decode($ngdu_data)
        ]]);
    }

    public function general($public_id)
    {
        $operation_data = DB::table('Well as we')
        ->join('WellState as st', 'we.WellState_Id', '=', 'st.Id')
        ->join('Ngdu as ngdu', 'we.Ngdu_Id', '=', 'ngdu.Id')
        ->join('Shop as sh', 'we.Shop_Id', '=', 'sh.Id')
        ->join('Plc as pl', 'we.Plc_Id', '=', 'pl.Id')
        ->join('Hd as h', 'we.Hd_Id', '=', 'h.Id')
        ->join('Map as mp', 'we.Map_Id', '=', 'mp.Id')
        ->join('Uplc as upl', 'we.Uplc_Id', '=', 'upl.Id')
        ->orderBy('we.Ngdu_Id')
        ->orderBy('we.Id')
        ->select([
            'we.Id',
            'we.public_id',
            'we.Ngdu_Id',
            'we.WellState_Id',
            'we.Shop_Id',
            'we.Plc_Id',
            'we.Hd_Id',
            'we.Map_Id',
            'we.Uplc_Id',
            'ngdu.NgduName as NgduName',
            'pl.Name as PlcName',
            'sh.ShopName as ShopName',
            'h.Hdname as HdName',
            'we.Name',
            'we.FlDiagnost',
            'we.Ask',
            'we.Connect',
            'we.Web',
        ])
        ->where('we.public_id', '=', $public_id)
        ->first();

        return Inertia::render('Operations/Detail', ['data' => $operation_data]);
    }

    public function hourArch($id) {
        
    }
}
