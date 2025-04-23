<?php

namespace App\Interfaces\Customers;

use App\Interfaces\Admin\SoftDeleteInterface;
use App\Models\CustomerGroup;

interface CustomerRepositoryInterface extends SoftDeleteInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function syncMarkups($customerId, array $markups);

    public function createGroup(array $data): CustomerGroup;

}
