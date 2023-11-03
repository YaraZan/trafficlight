<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class AlarmsController extends Controller
{
    public function index()
    {
        if (Gate::allows('view-wells', User::class)) { 
            $alarms_data = DB::table('FaultLog as fl')
            ->join('Well as we', 'fl.Id_Well', '=', 'we.Id')
            ->join('MbReg as mb', 'fl.Id_Reg', '=', 'mb.Id')
            ->join('Ngdu as n', 'we.Ngdu_Id', '=', 'n.Id')
            ->select([
                'fl.Date',
                'n.Id as Ngdu_Id',
                'we.Name as WellName',
                'mb.RegDescript as RegDescript',
                'fl.Value',
            ])
            ->orderBy('fl.Date', 'desc')
            ->take(1500)
            ->get();
        } else {
            $user = auth()->user();
            $alarms_data = DB::table('FaultLog as fl')
            ->join('Well as we', 'fl.Id_Well', '=', 'we.Id')
            ->join('MbReg as mb', 'fl.Id_Reg', '=', 'mb.Id')
            ->join('Ngdu as n', 'we.Ngdu_Id', '=', 'n.Id')
            ->select([
                'fl.Date',
                'n.Id as Ngdu_Id',
                'we.Name as WellName',
                'mb.RegDescript as RegDescript',
                'fl.Value',
            ])
            ->where('Ngdu_Id', '=', $user->ngdu_id)
            ->orderBy('fl.Date', 'desc')
            ->take(1500)
            ->get();
        }
        

        return Inertia::render('Alarms/Index', ['alarms_data' => json_decode($alarms_data)]);
    }
}
