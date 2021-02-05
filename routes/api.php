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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('raca', 'RacaController');
Route::resource('cliente', 'ClienteController');
Route::resource('veterinario', 'VeterinarioController');
Route::resource('especialidade', 'EspecialidadeController');
Route::resource('pet', 'PetController');
Route::resource('clinica', 'ClinicaController');
Route::get('raca/load', 'RacaController@loadJson');
Route::get('cliente/load', 'ClienteController@loadJson');
Route::get('veterinario/load', 'VeterinarioController@loadJson');
Route::get('especialidade/load', 'EspecialidadeController@loadJson');
Route::get('pet/load', 'PetController@loadJson');
Route::get('clinica/load', 'ClinicaController@loadJson');
