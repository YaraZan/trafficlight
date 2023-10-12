<?php

namespace App\Http\Controllers;

use App\Models\WellAlarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MatrixController extends Controller
{
    public function matrix()
    {
        $matrix_data = DB::table('WellAlarm as wa')
        ->join('Well as well', 'wa.Well_Id', '=', 'well.Id')
        ->join('Ngdu as ngdu', 'wa.Ngdu_Id', '=', 'ngdu.Id')
        ->join('Shop as sh', 'wa.Shop_Id', '=', 'sh.Id')
        ->join('WellState as st', 'wa.WState_Id', '=', 'st.Id')
        ->orderBy('wa.Ngdu_Id')
        ->orderBy('wa.Well_Id')
        ->select([
            'wa.Ngdu_Id',
            'wa.Well_Id',
            'wa.Shop_Id',
            'wa.WState_Id',
            'well.Name as WellName',
            'st.Name as WellState',
            "wa.Date",
            'wa.SumErr',
            'well.Ask',
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
            'well.Web',
        ])
        ->get();
    


        return Inertia::render('Matrix/Matrix', ['matrix_data' => json_decode($matrix_data)]);
    }
}
