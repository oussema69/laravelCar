<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
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

// Authentication api
Route::post('/login', [AuthController::class, 'auth']);

// User register api
Route::post('/register',[AuthController::class, 'createUser'] );
//user apis
//{
Route::get('/users/{id}', [RoleController::class, 'getUserById']);
Route::get('/users/role/{role}', [RoleController::class, 'getUsersByRole']);
Route::put('/users/{id}', [RoleController::class, 'updateUser']);
Route::delete('/users/{id}', [RoleController::class, 'deleteUser']);

//}
