<?php

namespace App\Services;

use App\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    protected $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function getStoreByUser($userId)
    {
        return $this->storeRepository->findByUser($userId);
    }

    public function createStore($userId, array $data, ?UploadedFile $logo)
    {
        $data['user_id'] = $userId;
        $data['is_verified'] = false;
        
        // Hardcoded for now as per original controller
        $data['address_id'] = 1; 

        if ($logo) {
            $path = $logo->store('store_logos', 'public');
            $data['logo'] = $path;
        }

        return $this->storeRepository->create($data);
    }

    public function updateStore($store, array $data, ?UploadedFile $logo)
    {
        if ($logo) {
            // Delete old logo if exists
            if ($store->logo && $store->logo !== 'wtc-logo.png') {
                Storage::disk('public')->delete($store->logo);
            }

            $path = $logo->store('store_logos', 'public');
            $data['logo'] = $path;
        }

        return $this->storeRepository->update($store, $data);
    }

    public function deleteStore($store)
    {
        if ($store->logo && $store->logo !== 'wtc-logo.png') {
            Storage::disk('public')->delete($store->logo);
        }

        return $this->storeRepository->delete($store);
    }
}
