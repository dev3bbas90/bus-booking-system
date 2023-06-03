<?php
namespace App\Repositories;

use App\Interfaces\BusInterface;
use App\Models\Bus;

class BusRepository extends BaseRepository implements BusInterface
{
    protected $model;
    public function __construct(Bus $model)
    {
        $this->model =$model;
    }

}
