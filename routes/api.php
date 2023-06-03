<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;


Route::group([ 'prefix' => 'auth' , 'as' => 'auth.' ], function () {
    Route::post('login'     , [Auth\AuthController::class, 'login'])    ->name('login');
    Route::post('logout'    , [Auth\AuthController::class, 'logout'])   ->name('logout');
    Route::post('refresh'   , [Auth\AuthController::class, 'refresh'])  ->name('refresh');
    Route::get('profile'    , [Auth\AuthController::class, 'profile'])  ->name('profile');
});

Route::group(['middleware'  => ['auth:api', 'jwt.verify']], function () {

    /**
     * Get stations to use in trip search and reservation
    */
    Route::get('stations'   , [StationController::class, 'index'])      ->name('api.stations.index');

    /**
     * trip apis
    */
    Route::group(['prefix'  => 'trips'  , 'as' => 'trips.'], function () {
        Route::get('/'                  , [TripController::class    , 'index'])          ->name('index');
        Route::get('/{trip}'            , [TripController::class    , 'show'])           ->name('show');
        Route::post('available-seats'   , [TripController::class    , 'available_seats'])->name('available_seats');
    });

    Route::group(['prefix'  => 'bookings' , 'as' => 'bookings.'], function () {
        Route::get('/'          , [BookingController::class    , 'index'])->name('index');
        Route::get('/{id}'      , [BookingController::class    , 'show']) ->name('show');
        Route::post('/store'    , [BookingController::class    , 'store']) ->name('store');
    });

    Route::group(['prefix' => 'buses' , 'as' => 'buses.']  , function () {
        // Route::get('/{bus}', [BusController::class, 'show'])              ->name('index');
    });

});
