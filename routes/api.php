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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::POST('/profileUpdate', 'Employees\EmployeeController@profileUpdate');
Route::any('/getEmpImage', 'ApiController@getEmpImage');
Route::any('/getUsersForWebsite', 'ApiController@getUsersForWebsite');
Route::any('/getUsers', 'ApiController@getUsers');
Route::any('/login', 'ApiController@getUsersForLogin');
Route::any('/mohsin-post-api', 'ApiController@mohsinPostApi');
