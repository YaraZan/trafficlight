<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WellAlarmsController extends Controller
{
    public function index($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();
        $this->authorize('view', $well);
        
        $well_item = DB::table('Well')->select('Id', 'public_id', 'Name')->where('public_id', '=', $well_uuid)->first();

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
        ->where('fl.Id_Well', '=', $well_item->Id)
        ->take(1500)
        ->get();

        return Inertia::render('Matrix/Alarms', [
            'data' => $alarms_data,
            'item' => $well_item
        ]);
    }
}
