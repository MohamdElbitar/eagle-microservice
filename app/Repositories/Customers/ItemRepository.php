<?php

namespace App\Repositories\Customers;

use App\Interfaces\Customers\ItemRepositoryInterface;
use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

class ItemRepository implements ItemRepositoryInterface
{
    public function getAll(): Collection
    {
        return Item::with('types')->get();
    }

    public function findById(int $id)
    {
        return Item::with('types')->find($id);
    }

    public function create(array $data): Item
    {
       return Item::create($data);
    }

    public function update( int $id, array $data)
    {
        if (($item = $this->findById($id))?->update($data)) {
            return $item;
        }

        return false;
    }

    public function delete(int $id): Int
    {
        return Item::destroy($id);
    }

    public function restore(int $id)
    {
        return Item::onlyTrashed()
                ->findOrFail($id)
                ->restore();
    }

    public function forceDelete(int $id)
    {
        return Item::onlyTrashed()
                ->findOrFail($id)
                ->forceDelete();
    }

    public function createTypes(int $itemID, array $data)
    {
        $this->findById($itemID)
                ->types()
                ->createMany($data);
    }

    public function updateType(int $typeID, array $data)
    {
        return ItemType::where('id', $typeID)  
                        ->update($data);
    }

    public function deleteType(int $typeID)
    {
        return ItemType::where('id', $typeID)->delete();
    }
}
