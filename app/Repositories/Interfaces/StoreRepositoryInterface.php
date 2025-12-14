<?php

namespace App\Repositories\Interfaces;

use App\Models\Store;

interface StoreRepositoryInterface
{
    public function findByUser($userId);
    public function create(array $data);
    public function update(Store $store, array $data);
    public function delete(Store $store);
}
