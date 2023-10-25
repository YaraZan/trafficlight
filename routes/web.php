<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlarmsController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MatrixController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
Route::redirect('/', '/traffic-light/matrix');
Route::redirect('/traffic-light', '/traffic-light/matrix');

/**
 * Matrix routes
 */
Route::get('/traffic-light/matrix', [MatrixController::class, 'index'])->name('matrix');
Route::get('/traffic-light/matrix/{operation_uuid}', [MatrixController::class, 'detail'])->name('matrix.detail'); 
Route::get('/traffic-light/matrix/{operation_uuid}/hourarch', [MatrixController::class, 'hourArch'])->name('matrix.hourarch');
Route::get('/traffic-light/matrix/{operation_uuid}/hourarch/{head_hour_uuid}', [MatrixController::class, 'hourArchDetail'])->name('matrix.hourarch.detail');

Route::get('/traffic-light/matrix/{operation_uuid}/askstats', [MatrixController::class, 'askStats'])->name('matrix.askstats');

/**
 * Alarms routes
 */
Route::get('/traffic-light/alarms', [AlarmsController::class, 'index'])->name('alarms');

/**
 * Analytics routes
 */
Route::get('/traffic-light/analytics', function () {
    return Inertia::render('Analytics/Analytics');
})->name('analytics');


/**
 * !!! Admin routes !!!
 */
Route::get('/traffic-light/logs', [LogController::class, 'index'])->name('logs');

Route::get('/traffic-light/users', [UserController::class, 'index'])->name('users');
Route::post('/traffic-light/users', [UserController::class, 'store'])->name('users.store');
Route::patch('/traffic-light/users', [UserController::class, 'update'])->name('users.update');
Route::delete('/traffic-light/users', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/traffic-light/roles', [RoleController::class, 'index'])->name('roles');
Route::post('/traffic-light/roles', [RoleController::class, 'store'])->name('roles.store');
Route::patch('/traffic-light/roles', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/traffic-light/roles', [RoleController::class, 'destroy'])->name('roles.destroy');



require __DIR__.'/auth.php';
