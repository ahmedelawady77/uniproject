<?php

use App\Http\Controllers\MobileAppControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('regsisterapp','AuthController@register');
    Route::post('loginapp', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('/products','ProductController@index');
    Route::get('/products/{id?}','ProductController@show');
    Route::get('/whishlist',"favController@getfavitem");
    Route::post('/like',"favController@makefavitem");
    Route::delete('/unlike/{id?}','favController@delfavitem');
    Route::post('forgetpassword', 'ForgetPassword@forgetpassword');
    Route::post('/validateotp','ForgetPassword@validateOtp');
    Route::post('/resetpassword/{otp?}','ForgetPassword@resetpassword');

});
