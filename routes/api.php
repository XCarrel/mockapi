<?php

use App\Http\Controllers\API\FiameController;
use App\Http\Controllers\API\NextepController;
use App\Http\Controllers\API\RunForCauseController;
use App\Models\User;
use App\Http\Controllers\API\ProductController;
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
Route::middleware('auth:api')->get('/rfc/me', [RunForCauseController::class,'showCurrentUser']);
Route::middleware('auth:api')->patch('/rfc/profile',[RunForCauseController::class, 'update']);
Route::middleware('auth:api')->post('/rfc/location',[RunForCauseController::class, 'store']);
Route::post('/rfc/mytoken',[RunForCauseController::class,'mytoken']);

// Nextep endpoints
Route::middleware('auth:api')->get('/nxp/profile', [NextepController::class, 'profile']);
Route::middleware('auth:api')->patch('/nxp/profile',[NextepController::class, 'update']);
Route::post('/nxp/mytoken',[NextepController::class,'mytoken']);
Route::middleware('auth:api')->post('/nxp/profile/photo',[NextepController::class,'uploadPhoto']);
Route::middleware('auth:api')->get('/nxp/voting_topics', [NextepController::class, 'votingTopics']);

// Fiame
Route::post('/fiame/mytoken',[FiameController::class,'mytoken']);
Route::middleware('auth:api')->get('/fiame/me', [FiameController::class, 'profile']);
Route::middleware('auth:api')->get('/fiame/mypurchases',[FiameController::class,'mypurchases']);
Route::middleware('auth:api')->get('/fiame/products',[FiameController::class,'products']);
Route::middleware('auth:api')->get('/fiame/users', [FiameController::class,'users']);
Route::middleware('auth:api')->post('/fiame/purchase', [FiameController::class,'purchase']);
