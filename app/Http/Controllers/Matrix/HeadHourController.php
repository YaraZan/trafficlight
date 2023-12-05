<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Well;
use Inertia\Inertia;

class HeadHourController extends Controller
{
    public function index($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();

        if (Gate::allows('view-well', $well) || Gate::allows('view-wells')) {

            $well_item = DB::table('Well')->select('Id', 'public_id', 'Name',)->where('public_id', '=', $well_uuid)
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

        return Inertia::render('Errors/NotAuthorized');
    }

    public function show($well_uuid, $head_hour_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();

        if (Gate::allows('view-well', $well) || Gate::allows('view-wells')) {

            $well_item = DB::table('Well')->select('Id', 'public_id', 'Name',)->where('public_id', '=', $well_uuid)
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

        return Inertia::render('Errors/NotAuthorized');
    }
}
