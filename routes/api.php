<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RunForCauseController;
use App\Http\Controllers\API\NextepController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
Route::middleware('auth:api')->get('/nxp/me', function (Request $request) {
    return response(json_encode(User::find(Auth::user()->user_id)), 200);
});
Route::post('/nxp/mytoken',[NextepController::class,'mytoken']);

