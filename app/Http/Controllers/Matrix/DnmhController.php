<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DnmhController extends Controller
{
    public function index($well_id)
    {
        $dnmh = DB::table('Dnmh')->where('Well_Id', '=', $well_id)->get();

        return response()->json(['dnmh' => $dnmh]);
    }

    public function show($dnmh_id)
    {
        $dnm = DB::table('Dnm')->where('Dnmh_Id', '=', $dnmh_id)->get();

        return response()->json(['dnm' => $dnm]);
    }
}
