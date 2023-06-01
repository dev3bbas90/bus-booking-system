<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can access dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "dashboard" middleware group. Make something great!
|
*/

Route::group([ 'as' => 'dashboard.' ], function (){

    Route::group([ 'middleware' => 'guest:dashboard' ], function (){
        Route::get('login'      ,   [Auth\LoginController::class, 'getLogin'])  ->name('login.get');
        Route::post('login'     ,   [Auth\LoginController::class, 'login'])     ->name('login');
    });

    Route::group(['middleware' => 'auth:dashboard'], function (){
        Route::get('/'          ,   [HomeController::class, 'index'])           ->name('home');

        Route::post('logout'    ,   [Auth\LoginController::class, 'logout'])     ->name('logout');

        Route::resources([
            'stations'          => StationController::class,
            'buses'             => BusController::class,
            'trips'             => TripController::class
        ]);
    });

});
