<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AlarmsController extends Controller
{
    public function index()
    {
        $alarms_data = DB::table('FaultLog as fl')
        ->join('Well as we', 'fl.Id_Well', '=', 'we.Id')
        ->join('MbReg as mb', 'fl.Id_Reg', '=', 'mb.Id')
        ->select([
            'fl.Date',
            'we.Name as WellName',
            'mb.RegDescript as RegDescript',
            'fl.Value',
        ])
        ->orderBy('fl.Date', 'desc')
        ->take(1500)
        ->get();

        return Inertia::render('Alarms/Index', ['alarms_data' => json_decode($alarms_data)]);
    }
}
