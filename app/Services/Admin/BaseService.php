<?php
namespace App\Services\Admin;


use App\Services\Admin\IService;
use Illuminate\Support\Collection;

class BaseService implements IService
{
    public $repo;

    /**
     * @param $repo
     * @return mixed
     */
    public function getRepo($repo)
    {
        $this->repo = new $repo;
        return $this->repo;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repo->all();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return $this->repo->findById($id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->repo->destroy($id);
    }
}
