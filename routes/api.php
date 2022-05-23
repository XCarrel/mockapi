<?php

use App\Http\Controllers\API\FiameController;
use App\Http\Controllers\API\NextepController;
use App\Http\Controllers\API\RunForCauseController;
use App\Models\User;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Run for cause endpoints
Route::middleware('auth:api')->get('/rfc/me', function (Request $request) {
    return response(json_encode(User::find(Auth::user()->user_id)), 200);
});
Route::post('/rfc/mytoken',[RunForCauseController::class,'mytoken']);

// Nextep endpoints
Route::middleware('auth:api')->get('/nxp/profile', [NextepController::class, 'profile']);
Route::post('/nxp/mytoken',[NextepController::class,'mytoken']);

// Fiame
Route::post('/fiame/mytoken',[FiameController::class,'mytoken']);
Route::middleware('auth:api')->get('/fiame/me', [FiameController::class, 'profile']);
Route::middleware('auth:api')->get('/fiame/mypurchases',[FiameController::class,'mypurchases']);
Route::prefix('fiame')->name('fiame.')->group(function () {
    Route::apiResource('products',ProductController::class);
});
