<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', [LoginController::class, 'getUser']);

Route::middleware('auth:sanctum')->get('/duty', [\App\Http\Controllers\DutyController::class, 'getDuty']);
Route::middleware('auth:sanctum')->post('/duty/set', [\App\Http\Controllers\DutyController::class, 'setDuty']);
Route::middleware('auth:sanctum')->get('/duty/count', [\App\Http\Controllers\DutyController::class, 'countDuty']);

Route::group(['prefix' => 'dispatch', 'middleware' => ['auth']], function(){
    Route::get('get', [\App\Http\Controllers\DispatchController::class, 'getDispatch']);
    Route::post('set', [\App\Http\Controllers\DispatchController::class, 'setDispatch']);
    Route::get('current', [\App\Http\Controllers\DispatchController::class, 'currentDispatchUser']);
});

Route::middleware('auth:sanctum')->get('/units', [\App\Http\Controllers\PatrolController::class, 'getPatrols']);
Route::middleware('auth:sanctum')->post('/units/set', [\App\Http\Controllers\PatrolController::class, 'setPatrols']);
Route::middleware('auth:sanctum')->post('/units/create', [\App\Http\Controllers\PatrolController::class, 'store']);
Route::middleware('auth:sanctum')->post('/units/destroy/{id}', [\App\Http\Controllers\PatrolController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/danger-level', [\App\Http\Controllers\DangerLevelController::class, 'index']);
Route::middleware('auth:sanctum')->post('/danger-level/store', [\App\Http\Controllers\DangerLevelController::class, 'store']);

Route::middleware('auth:sanctum')->get('/investigation', [\App\Http\Controllers\InvestigationController::class, 'index']);
Route::middleware('auth:sanctum')->post('/investigation/store', [\App\Http\Controllers\InvestigationController::class, 'store']);
Route::middleware('auth:sanctum')->get('/investigation/{id}', [\App\Http\Controllers\InvestigationController::class, 'show']);

Route::group(['prefix' => 'others', 'middleware' => ['auth']], function() {
    Route::group(['prefix' => 'licenses', 'middleware' => ['auth']], function() {
        Route::middleware('auth:sanctum')->get('/list', [\App\Http\Controllers\LicenseController::class, 'index']);
        Route::middleware('auth:sanctum')->post('/{id}/revoke', [\App\Http\Controllers\LicenseController::class, 'revoke']);
        Route::middleware('auth:sanctum')->get('/history', [\App\Http\Controllers\LicenseController::class, 'history']);
    });
});

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [RegisterController::class, 'register']);

Route::resource('policemans', \App\Http\Controllers\UserController::class);



