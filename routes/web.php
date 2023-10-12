<?php

use App\Http\Controllers\MatrixController;
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


// Home route
Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

/**
 * [->] Redirects
 */
Route::redirect('/traffic-light', '/traffic-light/matrix');


/**
 * Matrix routes
 */
Route::get('/traffic-light/matrix', [MatrixController::class, 'matrix'])->name('matrix');

/**
 * Alarms routes
 */
Route::get('/traffic-light/alarms', function () {
    return Inertia::render('Alarms/Alarms');
})->name('alarms');

/**
 * Operations routes
 */
Route::get('/traffic-light/operations', function () {
    return Inertia::render('Operations/Operations');
})->name('operations');

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
