<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Collection;

interface IRepo
{
    public function getModel($model);

    public function all() : Collection;

    public function create(array $data);

    public function update(int $id, array $data);

    public function findById(int $id);

    public function destroy(int $id);
}
