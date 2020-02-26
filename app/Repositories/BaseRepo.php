<?php


namespace App\Repositories;


use Illuminate\Support\Collection;

class BaseRepo implements IRepo
{
    /**
     * @var $model
     */
    private $model;

    /**
     * @param $model
     * @return mixed
     */
    public function getModel($model)
    {
        $this->model = new $model;
        return $this->model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
