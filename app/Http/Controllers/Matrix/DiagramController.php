<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Well;
use Inertia\Inertia;

class DiagramController extends Controller
{
    public function index($well_uuid) 
    {
        $well = Well::where('public_id', $well_uuid)->first();
        $this->authorize('view', $well);

        $well_item = DB::table('Well')->select('Id', 'public_id', 'Name',)->where('public_id', '=', $well_uuid)
        ->first();

        $categories = DB::table('Category')->select('Id', 'CatName', 'public_id')->get();

        return Inertia::render('Matrix/Diagrams', [
            'item' => $well_item,
            'categories' => $categories,
        ]);
    }

    public function show($well_uuid, $category_uuid) 
    {
        $well = Well::where('public_id', $well_uuid)->first();

        $category = DB::table('Category')->where('public_id', '=', $category_uuid)->first();

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
            'ha.Date as X',
            'ha.Ref1 as R',
            'ha.Cur1 as Y',
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
        ->where('ha.Category_Id', '=', $category->Id)
        ->where('ha.Well_Id', '=', $well->Id)
        ->orderBy('ha.Date', 'desc')
        ->take(500)
        ->get();

        return response()->json($hour_arch_data);
    }
}
