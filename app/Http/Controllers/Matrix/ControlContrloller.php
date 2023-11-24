<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use App\Models\Ngdu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class ControlContrloller extends Controller
{
    public function index($well_uuid)
    {
        $well = Well::where('public_id', $well_uuid)->first();

        if ((Gate::allows('view-wells') || Gate::allows('view-well', $well)) && Gate::allows('control-wells')) { 
            
            $well_item = DB::table('Well')->select('Id', 'public_id', 'Name')->where('public_id', '=', $well_uuid)->first();
    
            return Inertia::render('Matrix/Control', [
                'item' => $well_item
            ]);
        }

        return Inertia::render('Errors/NotAuthorized');

    }
}
