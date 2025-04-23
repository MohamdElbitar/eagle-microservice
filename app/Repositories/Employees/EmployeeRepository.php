<?php

namespace App\Repositories\Employees;

use App\Interfaces\Employees\EmployeeRepositoryInterface;
use App\Models\Employee;


class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll()
    {
        return Employee::with(['user', 'attributes.attribute'])->get();
    }

    public function findById($id)
    {
        return Employee::with(['user', 'attributes.attribute'])->find($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update(int $id, array $data)
    {
        if (($department = $this->findById($id))?->update($data) ) {
            return $department;
        }

        return false;
    }

    public function delete(int $id)
    {
        // Delete linked user if exists
        if (! ($employee = Employee::find($id))) {
            return false;
        }

        $employee->user?->delete();
        $employee->delete();

        return true;
    }

    public function restore(int $id)
    {
        return Employee::onlyTrashed()
                ->findOrFail($id)
                ->restore();
    }

    public function forceDelete(int $id)
    {
        return Employee::onlyTrashed()
                ->findOrFail($id)
                ->forceDelete();
    }
}
