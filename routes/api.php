<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;


Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('login'     , [Auth\AuthController::class, 'login']);
    Route::post('logout'    , [Auth\AuthController::class, 'logout']);
    Route::post('refresh'   , [Auth\AuthController::class, 'refresh']);
    Route::get('profile'    , [Auth\AuthController::class, 'profile']);
});

Route::group(['middleware'  => ['auth:api', 'jwt.verify']], function () {

    /**
     * Get stations to use in trip search and reservation
    */
    Route::get('stations'   , [StationController::class, 'index']);

    /**
     * trip apis
    */
    Route::group(['prefix'  => 'trips'], function () {
        Route::get('/'                  , [TripController::class    , 'index']);
        Route::get('/{trip}'            , [TripController::class    , 'show']);
        Route::post('available-seats'   , [TripController::class    , 'available_seats']);
    });

    Route::group(['prefix'  => 'bookings'], function () {
        Route::get('/'          , [BookingController::class    , 'index']);
        Route::get('/{id}'      , [BookingController::class    , 'show']);
        Route::post('/book'     , [BookingController::class    , 'book']);
    });


    Route::post('/book-seat'            , [BookingController::class , 'book']);

    Route::group(['prefix' => 'buses']  , function () {
        Route::get('/{bus}', [BusController::class, 'show']);
    });

});
