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
Route::middleware('auth:sanctum')->post('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

Route::group(['prefix' => 'admin/', 'middleware' => ['auth']], function(){
    Route::get('user/{id}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::post('user', [\App\Http\Controllers\UserController::class, 'update']);
    Route::post('grade/order', [\App\Http\Controllers\GradesController::class, 'updateOrder']);
    Route::get('grade/{id}', [\App\Http\Controllers\GradesController::class, 'show']);
    Route::post('grade', [\App\Http\Controllers\GradesController::class, 'create']);
    Route::post('grade/{id}', [\App\Http\Controllers\GradesController::class, 'update']);
    Route::post('grade/destroy/{id}', [\App\Http\Controllers\GradesController::class, 'destroy']);
    Route::get('tariff', [\App\Http\Controllers\TariffController::class, 'index']);
    Route::post('tariff', [\App\Http\Controllers\TariffController::class, 'store']);
    Route::get('tariff/{id}', [\App\Http\Controllers\TariffController::class, 'show']);
    Route::post('tariff/{id}', [\App\Http\Controllers\TariffController::class, 'update']);
    Route::post('tariff/destroy/{id}', [\App\Http\Controllers\TariffController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

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

Route::group(['prefix' => 'investigation', 'middleware' => ['auth']], function() {
    Route::middleware('auth:sanctum')->get('/', [\App\Http\Controllers\InvestigationController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/store', [\App\Http\Controllers\InvestigationController::class, 'store']);
    Route::middleware('auth:sanctum')->post('/attach', [\App\Http\Controllers\InvestigationController::class, 'attachSuspects']);
    Route::middleware('auth:sanctum')->get('/{id}', [\App\Http\Controllers\InvestigationController::class, 'show']);
    Route::middleware('auth:sanctum')->post('/close', [\App\Http\Controllers\InvestigationController::class, 'close']);
    Route::middleware('auth:sanctum')->post('/comment', [\App\Http\Controllers\InvestigationCommentController::class, 'store']);
});

Route::middleware('auth:sanctum')->post('/wanted-create', [\App\Http\Controllers\WantedController::class, 'store']);
Route::middleware('auth:sanctum')->post('/wanted-destroy', [\App\Http\Controllers\WantedController::class, 'destroy']);

Route::group(['prefix' => 'others', 'middleware' => ['auth']], function() {
    Route::group(['prefix' => 'licenses', 'middleware' => ['auth']], function() {
        Route::middleware('auth:sanctum')->get('/list', [\App\Http\Controllers\LicenseController::class, 'index']);
        Route::middleware('auth:sanctum')->post('/add', [\App\Http\Controllers\LicenseController::class, 'store']);
        Route::middleware('auth:sanctum')->post('/{id}/revoke', [\App\Http\Controllers\LicenseController::class, 'revoke']);
        Route::middleware('auth:sanctum')->get('/history', [\App\Http\Controllers\LicenseController::class, 'history']);
    });
});

Route::group(['prefix' => 'crime', 'middleware' => ['auth']], function() {
    Route::middleware('auth:sanctum')->get('/', [\App\Http\Controllers\CrimeController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/store', [\App\Http\Controllers\CrimeController::class, 'store']);
    Route::middleware('auth:sanctum')->get('/criminals', [\App\Http\Controllers\CrimeController::class, 'getCriminalsCrimes']);
    Route::middleware('auth:sanctum')->get('/{id}', [\App\Http\Controllers\CrimeController::class, 'show']);

});

Route::group(['prefix' => 'grade', 'middleware' => ['auth']], function() {
    Route::middleware('auth:sanctum')->get('/list', [\App\Http\Controllers\GradesController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/tariff', [\App\Http\Controllers\TariffController::class, 'index']);


Route::middleware('auth:sanctum')->get('/characters', [\App\Http\Controllers\CharactersController::class, 'index']);
Route::middleware('auth:sanctum')->get('/characters/{id}', [\App\Http\Controllers\CharactersController::class, 'show']);


Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [RegisterController::class, 'register']);

Route::resource('policemans', \App\Http\Controllers\UserController::class);



