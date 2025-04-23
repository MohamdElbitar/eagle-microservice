<?php

namespace App\Interfaces\Customers;

use App\Interfaces\Admin\SoftDeleteInterface;


interface ContractRepositoryInterface extends SoftDeleteInterface
{
    public function all();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function syncFees($contractId, array $contractFees);

}
