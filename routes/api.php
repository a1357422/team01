<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\BedsController;
use App\Http\Controllers\DormitoriesController;
use App\Http\Controllers\SbrecordsController;
use App\Http\Controllers\RollcallsController;
use App\Http\Controllers\LatesController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\UsersController;


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

Route::post('register', [AuthController::class, 'register']);

Route::post('login',  [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // 查詢所有學生
    Route::get('students', [StudentsController::class, 'api_students']);
    // 修改指定學生
    Route::patch('students', [StudentsController::class, 'api_update']);
    // 刪除指定學生
    Route::delete('students', [StudentsController::class, 'api_delete']);
    Route::get('beds', [BedsController::class, 'api_beds']);
    Route::patch('beds', [BedsController::class, 'api_update']);
    Route::delete('beds', [BedsController::class, 'api_delete']);
    Route::get('dormitories', [DormitoriesController::class, 'api_dormitories']);
    Route::patch('dormitories', [DormitoriesController::class, 'api_update']);
    Route::delete('dormitories', [DormitoriesController::class, 'api_delete']);
    Route::get('sbrecords', [SbrecordsController::class, 'api_sbrecords']);
    Route::patch('sbrecords', [SbrecordsController::class, 'api_update']);
    Route::delete('sbrecords', [SbrecordsController::class, 'api_delete']);
    Route::get('rollcalls', [RollcallsController::class, 'api_rollcalls']);
    Route::patch('rollcalls', [RollcallsController::class, 'api_update']);
    Route::delete('rollcalls', [RollcallsController::class, 'api_delete']);
    Route::get('lates', [LatesController::class, 'api_lates']);
    Route::patch('lates', [LatesController::class, 'api_update']);
    Route::delete('lates', [LatesController::class, 'api_delete']);
    Route::get('leaves', [LeavesController::class, 'api_leaves']);
    Route::patch('leaves', [LeavesController::class, 'api_update']);
    Route::delete('leaves', [LeavesController::class, 'api_delete']);
    Route::get('features', [FeaturesController::class, 'api_features']);
    Route::patch('features', [FeaturesController::class, 'api_update']);
    Route::delete('features', [FeaturesController::class, 'api_delete']);
    Route::get('users', [UsersController::class, 'api_users']);
    Route::patch('users', [UsersController::class, 'api_update']);
    Route::delete('users', [UsersController::class, 'api_delete']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
