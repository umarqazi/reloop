<?php


namespace App\Services;


use App\Repositories\UserRepo;
use App\Service\IService;
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
     */
    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    /**
     * @param int $id
     */
    public function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     */
    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }
}
