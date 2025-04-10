<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/rooms/{room}/prices', [RoomPriceController::class, 'apiPrices']);
    Route::get('/rooms/{room}/availability', [RoomAvailabilityController::class, 'apiAvailability']);
});

Route::get('/branches', [App\Http\Controllers\Api\BranchController::class, 'index']);
Route::get('/branches/{branchId}', [App\Http\Controllers\Api\BranchController::class, 'getBranchById']);
Route::get('/branches/{branchId}/room-prices', [App\Http\Controllers\Api\BranchController::class, 'getRoomPrices']);
