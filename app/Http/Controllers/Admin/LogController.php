<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Events\UserAction;
use Inertia\Inertia;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::whereDate( 'created_at', '<=', now()->subDays(90))->delete();

        $logs = Log::with('user')->orderBy('created_at','desc')->take(2000)->get();
        return Inertia::render('Logs/Index', ['logs' => $logs]);
    }
}
