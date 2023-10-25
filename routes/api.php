<?php

use App\Http\Controllers\Api\MatrixController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Matrix routes
 */
Route::get('/matrix', [MatrixController::class, 'index']);
Route::get('/matrix/{operation_uuid}', [MatrixController::class, 'detail']); 
Route::get('/matrix/{operation_uuid}/hourarch', [MatrixController::class, 'hourArch']);
Route::get('/matrix/{operation_uuid}/hourarch/{head_hour_uuid}', [MatrixController::class, 'hourArchDetail']);

Route::get('/matrix/{operation_uuid}/askstats', [MatrixController::class, 'askStats']);
