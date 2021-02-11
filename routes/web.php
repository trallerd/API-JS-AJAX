<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','ClinicaController@index');

Route::resource('cliente','ClienteController');
Route::resource('veterinario','VeterinarioController');
Route::resource('especialidade','EspecialidadeController');
Route::resource('pet','PetController');
Route::resource('raca','RacaController');
Route::resource('clinica','ClinicaController');