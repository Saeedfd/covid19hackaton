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

Route::group([
    'prefix'     => 'auth',
    'namespace'  => 'Authentication',
    'limit'      => 50,
    'expires'    => 1
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::group([
    'prefix'     => 'auth',
    'namespace'  => 'Authentication',
    'middleware' => 'auth:api',
    'limit'      => 50,
    'expires'    => 1
], function () {
    Route::get('logout', 'AuthController@logout');
    Route::post('set_password', 'AuthController@setPassword');
});

Route::group([
    'prefix'     => 'patient',
    'namespace'  => 'Patients',
    'middleware' => 'auth:api',
], function () {
    Route::get('single', 'PatientsController@GetSinglePatient');
    Route::get('/contacts', 'PatientsController@getContacts');
    Route::post('/', 'PatientsController@AddPatient');
});

Route::group([
    'prefix'     => 'user',
    'namespace'  => 'Users',
    'middleware' => 'auth:api',
], function () {
    Route::get('/', 'UsersController@getMyInformation');
});
