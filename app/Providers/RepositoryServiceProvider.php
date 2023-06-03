<?php

namespace App\Providers;

use App\Interfaces\BaseInterface;
use App\Interfaces\BookingInterface;
use App\Interfaces\BusInterface;
use App\Interfaces\StationInterface;
use App\Interfaces\TripInterface;
use App\Repositories\BaseRepository;
use App\Repositories\BookingRepository;
use App\Repositories\BusRepository;
use App\Repositories\StationRepository;
use App\Repositories\TripRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind( BaseInterface::class     ,   BaseRepository::class );
        $this->app->bind( BookingInterface::class  ,   BookingRepository::class );
        $this->app->bind( BusInterface::class      ,   BusRepository::class );
        $this->app->bind( StationInterface::class  ,   StationRepository::class );
        $this->app->bind( TripInterface::class     ,   TripRepository::class );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
