<?php

namespace App\Services\Customers;

use App\Interfaces\Customers\ItemRepositoryInterface;
use App\Models\Item;
use App\Models\ItemType;
use App\Repositories\Customers\ItemRepository;

class ItemService
{
    protected ItemRepository $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function getAllItems()
    {
        return $this->itemRepository->getAll();
    }

    public function getItemById(int $id)
    {
        return $this->itemRepository->findById($id);
    }

    public function createItem(array $data)
    {
        return $this->itemRepository->create($data);
    }

    public function updateItem(int $id, array $data)
    {
        return $this->itemRepository->update($id, $data);
    }

    public function deleteItem(int $id)
    {
        return $this->itemRepository->delete($id);
    }

    public function forceDelete(int $id)
    {
        return $this->itemRepository->forceDelete($id);
    }

    public function restore(int $id)
    {
        return $this->itemRepository->restore($id);
    }

    public function createTypes(int $id, $data)
    {
        return $this->itemRepository
                    ->createTypes($id, $data);
    }

    public function updateItemType(int $itemID, array $data)
    {
        $this->itemRepository
                    ->updateType($itemID, $data);

        return response(['message' => 'update succussfully!']);
    }

    public function deleteItemType(int $typeID)
    {
        $this->itemRepository->deleteType($typeID);

        return response(['message' => 'deletd succussfully'], 410);
    }
}
