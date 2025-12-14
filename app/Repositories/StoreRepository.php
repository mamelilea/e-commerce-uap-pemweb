<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Interfaces\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    public function findByUser($userId)
    {
        return Store::where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Store::create($data);
    }

    public function update(Store $store, array $data)
    {
        $store->update($data);
        return $store;
    }

    public function delete(Store $store)
    {
        return $store->delete();
    }
}
