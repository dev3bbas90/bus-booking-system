<?php
namespace App\Repositories;

use App\Interfaces\StationInterface;
use App\Models\Station;

class StationRepository extends BaseRepository implements StationInterface
{
    protected $model;
    public function __construct(Station $model)
    {
        $this->model =$model;
    }

}
