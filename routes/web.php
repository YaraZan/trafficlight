<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Matrix\DnmhController;
use App\Http\Controllers\AlarmsController;
use App\Http\Controllers\Matrix\AskStatsController;
use App\Http\Controllers\Matrix\WellController;
use App\Http\Controllers\Matrix\WellAlarmsController;
use App\Http\Controllers\Matrix\HeadHourController;
use App\Http\Controllers\Matrix\MoveWellController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\ClaimsController;
use App\Http\Controllers\ClaimStatusController;
use App\Http\Controllers\Matrix\ControlController;
use App\Http\Controllers\Matrix\DiagramController;
use \App\Http\Controllers\Dinamograph\TrainingController;
use App\Http\Controllers\Matrix\NgduController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
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
 * [->] Redirect from home.
 */
Route::get('/', function () {
    return redirect('/matrix');
})->name('home');

/**
 * ------------------ WEB ROUTES ---------------------------------
 */
Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * Matrix routes
     *
     * Routes for matrix page and its subpages containing
     * detail well page, archieves, etc.
     */
    Route::get('/matrix', [WellController::class, 'index'])->name('matrix');
    Route::get('/matrix/{well_uuid}', [WellController::class, 'show'])->name('matrix.detail');
    Route::get('/matrix/{well_uuid}/hourarch', [HeadHourController::class, 'index'])->name('matrix.hourarch');
    Route::get('/matrix/{well_uuid}/hourarch/{head_hour_uuid}', [HeadHourController::class, 'show'])->name('matrix.hourarch.detail');
    Route::get('/matrix/{well_uuid}/askstats', [AskStatsController::class, 'index'])->name('matrix.askstats');
    Route::get('/matrix/{well_uuid}/alarms', [WellAlarmsController::class, 'index'])->name('matrix.alarms');
    Route::get('/matrix/{well_uuid}/diagrams', [DiagramController::class, 'index'])->name('matrix.diagrams');
    Route::get('/matrix/{well_uuid}/control', [ControlController::class, 'index'])->name('matrix.control');

    /**
     * Alarms routes
     *
     * Routes for alarm page.
     */
    Route::get('/alarms', [AlarmsController::class, 'index'])->name('alarms');

    /**
     * Claims routes
     *
     * Routes for claims page.
     */
    Route::get('/claims', [ClaimsController::class, 'view'])->name('claims');

    /**
     * Settings routes
     *
     * Routes for settings page and its subpages as profile and data.
     */
    Route::get('/settings', function () { return redirect('/settings/profile'); })->name('settings');
    Route::get('/settings/profile', [ProfileController::class, 'index'])->name('settings.profile');
    Route::get('/settings/data', function () {
        return Inertia::render('Errors/Developing');
    })->name('settings.data');

    /**
     * Dinamograph routes
     *
     * Routes for ai training page, allowing trusted users to "train" it.
     */
    Route::get('/dinamograph', function () { return redirect('/dinamograph/training'); })->name('dinamograph');
    Route::get('/dinamograph/training', [TrainingController::class, 'index'])->name('dinamograph.training');

    /**
     * Docs routes
     *
     * Routes for documentation pages.
     */
    Route::prefix('/docs')->group(function () {
        Route::get('/matrix', function () { return redirect('/docs/matrix/table'); })->name('docs.matrix');
        Route::get('/well', function () { return redirect('/docs/well/dinamograms'); })->name('docs.well');

        Route::prefix('/matrix')->group(function () {
            Route::get('/table', function () { return Inertia::render('Docs/MatrixPage/Table');})->name('docs.matrix.table');
            Route::get('/filters', function () { return Inertia::render('Docs/MatrixPage/Filters');})->name('docs.matrix.filters');
        });
        Route::prefix('/well')->group(function () {
            Route::get('/dinamograms', function () { return Inertia::render('Docs/Well/Dinamograms'); })->name('docs.well.dinamograms');
            Route::get('/alarms', function () { return Inertia::render('Docs/Well/Alarms');})->name('docs.well.alarms');
            Route::get('/archive', function () { return Inertia::render('Docs/Well/Archive');})->name('docs.well.archive');
            Route::get('/parameters', function () { return Inertia::render('Docs/Well/Parameters');})->name('docs.well.parameters');
            Route::get('/claims', function () { return Inertia::render('Docs/Well/Claims');})->name('docs.well.claims');
            Route::get('/diagrams', function () { return Inertia::render('Docs/Well/Diagrams'); })->name('docs.well.diagrams');
            Route::get('/asklong', function () { return Inertia::render('Docs/Well/AskLong');})->name('docs.well.asklong');
        });
    });
});

/**
 * ------------------ API ROUTES ---------------------------------
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/api')->group(function () {

        Route::get('/control/{well_uuid}/categories', [ControlController::class, 'getCategoriesAndValues']);
        Route::get('/control/{well_uuid}/categories/fact', [ControlController::class, 'getCategoriesAndFactValues']);
        Route::get('/control/{well_uuid}/claims', [ControlController::class, 'getUserClaims']);
        Route::get('/control/{well_uuid}/well-claims', [ControlController::class, 'getWellClaims']);
        Route::get('/control/{well_uuid}/well-claims-untracked', [ControlController::class, 'getWellUntrackedClaims']);

        Route::post('/control/claims/track', [ControlController::class, 'trackClaim'])->name('claim.track');
        Route::post('/control/claims/create', [ControlController::class, 'createNewClaim'])->name('claim.create');
        Route::delete('/control/claims/delete', [ControlController::class, 'deleteClaim'])->name('claim.delete');

        Route::get('/well-claim/all-by-well/{well_uuid}', [MoveWellController::class, 'allByWell'])->name('well-claim.allByWell');
        Route::get('/well-claim/all-by-user/{well_uuid}', [MoveWellController::class, 'allByUser'])->name('well-claim.allByUser');
        Route::post('/well-claim/move-well', [MoveWellController::class, 'create'])->name('well-claim.create');
        Route::delete('/well-claim/delete', [MoveWellController::class, 'delete'])->name('well-claim.delete');

        Route::get('/dnmh/{public_id}', [DnmhController::class, 'index']);
        Route::get('/dnm/{public_id}', [DnmhController::class, 'show']);

        Route::get('/well/all', [WellController::class, 'all']);
        Route::get('/well/get', [WellController::class, 'get']);
        Route::get('/well/get-by-name/{name}', [WellController::class, 'getByName']);
        Route::get('/well/{well_uuid}/diagrams/{category_uuid}', [DiagramController::class, 'show']);

        Route::get('/claims/get', [ClaimsController::class, 'get'])->name('claims.get');
        Route::get('/claims/getCurrentValues', [ClaimsController::class, 'getCurrentValues'])->name('claims.getCurrentValues');
        Route::get('/claims/getClaimDetails', [ClaimsController::class, 'getClaimDetails'])->name('claims.getClaimDetails');
        Route::post('/claims/create', [ClaimsController::class, 'create'])->name('claims.create');

        Route::get('/ngdu/all', [NgduController::class, 'all']);

        Route::get('/claim_statuses/all', [ClaimStatusController::class, 'all']);

        Route::get('/category/all', [CategoryController::class, 'all']);
    });
});

/**
 * ------------------ ADMIN ROUTES ---------------------------------
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

    Route::get('/logs', [LogController::class, 'index'])->name('logs');
});

require __DIR__.'/auth.php';
