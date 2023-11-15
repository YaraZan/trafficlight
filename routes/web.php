<?php

use App\Http\Controllers\Matrix\DnmhController;
use App\Http\Controllers\AlarmsController;
use App\Http\Controllers\Matrix\AskStatsController;
use App\Http\Controllers\Matrix\WellController;
use App\Http\Controllers\Matrix\WellAlarmsController;
use App\Http\Controllers\Matrix\HeadHourController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Matrix\ControlContrloller;
use App\Http\Controllers\Matrix\DiagramController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * [->] Redirects
 */
Route::redirect('/', '/matrix');

/**
 * Matrix routes
 */

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/matrix', [WellController::class, 'index'])->name('matrix');
    Route::get('/matrix/{well_uuid}', [WellController::class, 'show'])->name('matrix.detail'); 
    Route::get('/matrix/{well_uuid}/hourarch', [HeadHourController::class, 'index'])->name('matrix.hourarch');
    Route::get('/matrix/{well_uuid}/hourarch/{head_hour_uuid}', [HeadHourController::class, 'show'])->name('matrix.hourarch.detail');
    Route::get('/matrix/{well_uuid}/askstats', [AskStatsController::class, 'index'])->name('matrix.askstats');
    Route::get('/matrix/{well_uuid}/alarms', [WellAlarmsController::class, 'index'])->name('matrix.alarms');
    Route::get('/matrix/{well_uuid}/diagrams', [DiagramController::class, 'index'])->name('matrix.diagrams');
    Route::get('/matrix/{well_uuid}/control', [ControlContrloller::class, 'index'])->name('matrix.control');

    Route::get('/alarms', [AlarmsController::class, 'index'])->name('alarms');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

Route::middleware('auth')->group(function () {
    Route::prefix('/api')->group(function () {
        Route::get('/dnmh/{public_id}', [DnmhController::class, 'index']);
        Route::get('/dnm/{public_id}', [DnmhController::class, 'show']);

        Route::get('well/{well_uuid}/diagrams/{category_uuid}', [DiagramController::class, 'show']);
    });
});

/**
 * Analytics routes
 */
Route::get('/analytics', function () {
    return Inertia::render('Analytics/Analytics');
})->name('analytics');


/**
 * !!! Admin routes !!!
 */
Route::middleware(['admin', 'auth', 'verified'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::patch('/roles', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');
});

require __DIR__.'/auth.php';
