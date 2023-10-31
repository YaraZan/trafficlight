<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\Well;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DnmhController extends Controller
{
    public function index($public_id)
    {
        $well = Well::where('public_id', '=', $public_id)->first();

        $dnmh = DB::table('Dnmh')->where('Well_Id', '=', $well->Id)->orderBy('Dat', 'desc')->get();

        return response()->json($dnmh);
    }

    public function show($public_id)
    {
        $dnmh = DB::table('Dnmh')->where('public_id', '=', $public_id)->first();
        $dnm = DB::table('Dnm')->where('Dnmh_Id', '=', $dnmh->Id)->get();

        return response()->json($dnm);
    }
}
