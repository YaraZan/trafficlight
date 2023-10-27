<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AskStatsController extends Controller
{
    public function index($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();
        $this->authorize('view', $well);
        
        $well_item = DB::table('Well')->select('Id', 'public_id', 'Name')->where('public_id', '=', $well_uuid)->first();

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
