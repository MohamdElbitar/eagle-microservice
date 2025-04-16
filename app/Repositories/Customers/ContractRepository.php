<?php

namespace App\Repositories\Customers;

use App\Interfaces\Customers\ContractRepositoryInterface;
use App\Models\{Contract, ContractFee, Customer};
use App\Services\CustomerService;

class ContractRepository implements ContractRepositoryInterface
{
    public function all()
    {
        return Contract::with('annex_departments', 'creditLimit')->get();
    }

    public function findById($id)
    {
        return Contract::with('creditLimit')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Contract::create($data);
    }

    public function update($id, array $data)
    {
        return Contract::findOrFail($id);
    }

    public function delete($id)
    {
        return Contract::destroy($id);
    }

    public function restore(int $id)
    {
        return Contract::onlyTrashed()
                ->find($id)
                ->restore();
    }

    public function forceDelete(int $id)
    {
        return Contract::onlyTrashed()
                ->find($id)
                ->forceDelete();
    }


    public function syncFees($contractId, array $contractFees)
    {
        foreach ($contractFees as $fee) {
            ContractFee::updateOrCreate(
                [
                    'contract_id' => $contractId,
                    'item_type_id' => $fee['item_type_id'],
                ],
                [
                    'fees' => $fee['fees'],
                    'value_type' => $fee['value_type'],
                    'currency' => $fee['currency'] ?? null,
                ]
            );
        }
    }
}

