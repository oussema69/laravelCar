<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\TacheController;
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
Route::post('/contact/create', [AuthController::class, 'createContact']);
Route::get('/contacts', [AuthController::class, 'getContact']);
Route::delete('/contacts/{id}', [AuthController::class, 'delete']);
Route::delete('/cars/{id}', [CarController::class, 'delete']);
Route::post('/cars', [CarController::class, 'store']);
Route::get('cars/users/{id}', [CarController::class, 'getCarsByUserId']);
Route::put('cars/{id}', [CarController::class, 'update']);
Route::get('cars/{id}', [CarController::class, 'getCar']);

Route::post('reclamations', [ReclamationController::class, 'createReclamation']);
Route::get('rec', [ReclamationController::class, 'getAll']);
Route::get('rec/user/{id}', [ReclamationController::class, 'getByUserId']);
Route::get('rec/{id}', [ReclamationController::class, 'getById']);
Route::get('reclamationsUsers/{id}', [ReclamationController::class, 'getReclamationsByUserId']);
Route::delete('/rec/{id}', [ReclamationController::class, 'delete']);
Route::put('rec/{id}', [ReclamationController::class, 'update']);
//
Route::post('inter', [InterventionController::class, 'store']);
Route::get('/inter/user/{user_id}', [InterventionController::class, 'getInterventionsByUser']);

Route::get('/inter/rec/{id}', [InterventionController::class, 'getByReclamationId']);
Route::get('/inter/{id}', [InterventionController::class, 'getInterventionById']);
Route::put('/inter/{id}', [InterventionController::class, 'update']);
Route::delete('/inter/{id}', [InterventionController::class, 'deleteIntervention']);
//
Route::post('tache', [TacheController::class, 'store']);
Route::put('/tache/{id}', [TacheController::class, 'update']);
Route::delete('/tache/{id}', [TacheController::class, 'delete']);
Route::get('/tache/{id}', [TacheController::class, 'getById']);
Route::get('/tache/inter/{id}', [TacheController::class, 'getTachesByInterventionId']);
Route::get('/rec/tech/{id}', [ReclamationController::class, 'getByTechId']);
Route::get('isvalid', [ReclamationController::class, 'index']);
Route::get('tache/type/{type}/{id}', [TacheController::class, 'getByType']);
Route::put('rec/update/isvalid/{id}', [ReclamationController::class, 'updateReclamationIsValid']);

//}
// GET api/interventions/{id}

