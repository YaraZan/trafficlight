<?php

use App\Http\Controllers\AlarmsController;
use App\Http\Controllers\MatrixController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LogController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/traffic-light')->group(function () {
        Route::get('/matrix', [MatrixController::class, 'index'])->name('matrix');
        Route::get('/matrix/{operation_uuid}', [MatrixController::class, 'detail'])->name('matrix.detail'); 
        Route::get('/matrix/{operation_uuid}/hourarch', [MatrixController::class, 'hourArch'])->name('matrix.hourarch');
        Route::get('/matrix/{operation_uuid}/hourarch/{head_hour_uuid}', [MatrixController::class, 'hourArchDetail'])->name('matrix.hourarch.detail');
        Route::get('/matrix/{operation_uuid}/askstats', [MatrixController::class, 'askStats'])->name('matrix.askstats');

        
        Route::get('/alarms', [AlarmsController::class, 'index'])->name('alarms');
    });
});



/**
 * Analytics routes
 */
Route::get('/traffic-light/analytics', function () {
    return Inertia::render('Analytics/Analytics');
})->name('analytics');


/**
 * !!! Admin routes !!!
 */
Route::middleware(['admin', 'auth', 'verified'])->group(function () {
    Route::prefix('/traffic-light')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/roles', [RoleController::class, 'index'])->name('roles');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::patch('/roles', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');
    });
});

require __DIR__.'/auth.php';
