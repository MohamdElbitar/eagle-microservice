<?php

namespace App\Interfaces\Employees;

use App\Interfaces\Admin\SoftDeleteInterface;

interface EmployeeRepositoryInterface extends SoftDeleteInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
