<?php

namespace App\Repositories\Customers;

use App\Interfaces\Customers\CustomerRepositoryInterface;
use App\Models\ContractFee;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomerMarkup;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAll()
    {
        return Customer::with(['itemMarkups', 'contracts'])->get();
    }

    public function findById(int $id): Customer
    {
        return Customer::with([
                    'itemMarkups',
                    'contracts',
                    'contracts.itemFees'
                ])->findOrFail($id);
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(int $id, array $data): Customer
    {
        ($customer = $this->findById($id))
            ->update($data);

        return $customer;
    }

    public function delete(int $id): int
    {
        return Customer::destroy($id);
    }

    public function restore(int $id)
    {
        return Customer::onlyTrashed()
                ->findOrFail($id)
                ->restore();
    }

    public function forceDelete(int $id)
    {
        return Customer::onlyTrashed()
                ->findOrFail($id)
                ->forceDelete();
    }

    public function syncMarkups($customerId, array $markups)
    {
        foreach ($markups as $markup) {
            CustomerMarkup::updateOrCreate(
                [
                    // 'fp_id' => $customerId,
                    'customer_id' => $customerId,
                    'item_type_id' => $markup['item_type_id'],
                ],
                [
                    'markup' => $markup['markup'],
                    'value_type' => $markup['value_type'],
                    'currency' => $markup['currency'] ?? null,
                ]
            );
        }
    }

    public function createGroup(array $data): CustomerGroup
    {
        return CustomerGroup::create($data);
    }

}
