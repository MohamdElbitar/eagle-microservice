<?php

namespace App\Repositories\Employees;

use App\Interfaces\Employees\EmployeeContractRepositoryInterface;
use App\Models\EmployeeContract;


class EmployeeContractRepository implements EmployeeContractRepositoryInterface
{
    public function getAll()
    {
        return EmployeeContract::all();
    }

    public function findById(int $id)
    {
        return EmployeeContract::first($id);
    }

    public function create(array $data)
    {
        return EmployeeContract::create($data);
    }

    public function show(int $id): EmployeeContract
    {
        return EmployeeContract::first($id);
    }

    public function update(int $id, array $data)
    {
        $contract = EmployeeContract::find($id);

        if (!$contract) {
            return false; // Return false if the contract does not exist
        }

        $contract->update($data);
        return $contract; // Return the updated contract
    }

    public function delete(int $id)
    {
        return EmployeeContract::find($id)->delete();
    }
}
