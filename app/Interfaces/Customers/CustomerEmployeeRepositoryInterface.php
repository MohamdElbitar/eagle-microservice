<?php

namespace App\Interfaces\Customers;

use App\Interfaces\Admin\SoftDeleteInterface;

interface CustomerEmployeeRepositoryInterface extends SoftDeleteInterface
{
    public function getAll(int $customer);
    public function findById(int $customer, int $customerEmployee);
    public function create(int $customer, array $data);
    public function update(int $customer, int $customerEmployee, array $data);
    public function delete(int $customer, int $customerEmployee);
}
