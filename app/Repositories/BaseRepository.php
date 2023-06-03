<?php
namespace App\Repositories;

use App\Interfaces\BaseInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseInterface
{
    /**
     * initiate new repository by custom model
     * @param Model $model
     * @return Model
    */
    protected $model;
    public function __construct(Model $model)
    {
        $this->model =$model;
    }

    public function all(array $columns=['*'],array $relations=[],array $where=[])
    {
        $data =  $this->model->where($where)->with($relations);
        return $data -> get($columns);
    }

    public function data(array $columns=['*'],array $relations=[],array $where=[])
    {
        return $this->model->where($where)->with($relations)->get();
    }

    public function find(int $id,array $columns=['*'],array $relations=[],array $appends=[])
    {
        try{
            return $this->model->select($columns)->with($relations)->find($id)?->append($appends) ;

        }catch(Exception $e)
        {
            throw new ModelNotFoundException('This ID '.$id.' Not Exist');
        }
    }

    public function store(array $data)
    {
        $model = $this->model->create($data );
        return $model->fresh();
    }

    public function update(int $id ,array $data)
    {
        $model = $this->find($id);
        $model->update($data );
        return $model;
    }

    public function delete(array $data)
    {
        return $this->find($data['id'])->delete();
    }

}
