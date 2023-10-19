<?php

use App\Http\Controllers\MatrixController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\ProfileController;
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

/**
 * Alarms routes
 */
Route::get('/traffic-light/alarms', function () {
    return Inertia::render('Alarms/Alarms');
})->name('alarms');

/**
 * Operations routes
 */
Route::get('/traffic-light/operations', [OperationsController::class, 'index'])->name('operations');

Route::get('/traffic-light/operations/{operation_uuid}', [OperationsController::class, 'detail'])->name('operations.detail'); 
Route::get('/traffic-light/operations/{operation_uuid}/hourarch', [OperationsController::class, 'hourArch'])->name('operations.hourarch');
Route::get('/traffic-light/operations/{operation_uuid}/hourarch/{head_hour_uuid}', [OperationsController::class, 'hourArchDetail'])->name('operations.hourarch.detail');

Route::get('/traffic-light/operations/{operation_uuid}/askstats', [OperationsController::class, 'askStats'])->name('operations.askstats');

/**
 * Analytics routes
 */
Route::get('/traffic-light/analytics', function () {
    return Inertia::render('Analytics/Analytics');
})->name('analytics');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
