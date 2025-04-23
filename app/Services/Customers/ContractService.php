<?php

namespace App\Services\Customers;

use App\Models\ContractCreditLimit;
use App\Repositories\Customers\ContractRepository;
use App\Interfaces\Customers\ContractRepositoryInterface;
use Illuminate\Support\Collection;

class ContractService
{
    protected ContractRepository $contractRepository;

    public function __construct(ContractRepositoryInterface $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

     public function createContract(array $data)
    {
        $contract = $this->contractRepository->create($data);


        $contract->annex_departments()
                    ->createMany(array_merge($data['fp_departments'], $data['sp_departments']));

        $contract->creditLimit()
                    ->create($data);

        return $contract;
    }

    public function getContracts()
    {
        return $this->contractRepository->all();
    }

    public function getContract($id)
    {
        return $this->contractRepository->findById($id);
    }


    public function updateContract(int $id, array $data)
    {
        return $this->contractRepository->update($id, $data);
    }

    public function deleteContract(int $id)
    {
        return $this->contractRepository->delete($id);
    }

    public function forceDelete(int $id)
    {
        return $this->contractRepository->forceDelete($id);
    }

    public function restore(int $id)
    {
        return $this->contractRepository->restore($id);
    }

    public function addFees(int $id, $data)
    {
        $this->contractRepository
                ->findById($id)
                ->itemFees()
                ->sync($data);
    }
}
