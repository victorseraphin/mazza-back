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
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::post('me', 'Api\AuthController@me');
});

Route::group(['middleware' => 'apiJwt'], function ($router) {
    Route::get('users', 'Api\UserController@index')->name('usuarios');
    Route::get('users/{id}', 'Api\UserController@show')->name('usuarios.listar');
    Route::post('users/salvar', 'Api\UserController@store')->name('usuarios.salvar');
    Route::post('users/atualizar/{id}', 'Api\UserController@update')->name('usuarios.atualizar');
    Route::get('users/deletar/{id}', 'Api\UserController@destroy')->name('usuarios.deletar');

    Route::get('medicos', 'Api\MedicosController@index')->name('medicos');
    Route::get('medicos/{id}', 'Api\MedicosController@show')->name('medicos.listar');
    Route::post('medicos/salvar', 'Api\MedicosController@store')->name('medicos.salvar');
    Route::post('medicos/atualizar/{id}', 'Api\MedicosController@update')->name('medicos.atualizar');
    Route::get('medicos/deletar/{id}', 'Api\MedicosController@destroy')->name('medicos.deletar');

    Route::get('pacientes', 'Api\PacientesController@index')->name('pacientes');
    Route::get('pacientes/{id}', 'Api\PacientesController@show')->name('pacientes.listar');
    Route::post('pacientes/salvar', 'Api\PacientesController@store')->name('pacientes.salvar');
    Route::post('pacientes/atualizar/{id}', 'Api\PacientesController@update')->name('pacientes.atualizar');
    Route::get('pacientes/deletar/{id}', 'Api\PacientesController@destroy')->name('pacientes.deletar');

    Route::get('agendamentos', 'Api\AgendamentosController@index')->name('agendamentos');
    Route::get('agendamentos/{id}', 'Api\AgendamentosController@show')->name('agendamentos.listar');
    Route::post('agendamentos/salvar', 'Api\AgendamentosController@store')->name('agendamentos.salvar');
    Route::post('agendamentos/atualizar/{id}', 'Api\AgendamentosController@update')->name('agendamentos.atualizar');
    Route::get('agendamentos/deletar/{id}', 'Api\AgendamentosController@destroy')->name('agendamentos.deletar');
});