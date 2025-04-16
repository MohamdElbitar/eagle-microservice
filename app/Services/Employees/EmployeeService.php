<?php

namespace App\Services\Employees;

use App\Interfaces\Employees\EmployeeRepositoryInterface;
use App\Interfaces\AttributesRepositoryInterface;
use App\Models\Employee;
use App\Repositories\AttributesRepository;
use App\Repositories\Employees\EmployeeRepository;
use App\Services\Admin\UserService;


class EmployeeService
{
    protected EmployeeRepository $employeeRepository;
    protected AttributesRepository $attributesRepository;



    public function __construct(
        EmployeeRepositoryInterface     $employeeRepository,
        AttributesRepositoryInterface   $attributesRepository,
        protected UserService           $userService
    )

    {
        $this->employeeRepository   = $employeeRepository;
        $this->attributesRepository = $attributesRepository;
        $this->userService          = $userService;
    }

    public function getAllEmployees()
    {
        return $this->employeeRepository->getAll();
    }

    public function getEmployeeById($id)
    {
        return $this->employeeRepository->findById($id);
    }

    public function createEmployee(array $data)
    {
        $created_by = auth()->user()->id;
        $data['created_by'] = $created_by;
        $createAccount = $data['create_account'] ?? false;
        unset($data['create_account']); // Remove from data array

        $password = $data['password'] ?? null;
        unset($data['password']); // Remove from data array

        $newAttributes = $data['new_attributes'] ?? [];
        unset($data['new_attributes']); // Remove to avoid SQL error

        // Create employee
        $employee = $this->employeeRepository->create($data);

        // Store attributes
        $this->attributesRepository->storeAttributes($employee->id, 'employee', $newAttributes);

        // Create user account if required
        if ($createAccount) {
            if (empty($data['work_email']) || empty($password)) {
                throw new \Exception("Email and Password are required to create an account.");
            }

            $userData = $data;
            $userData['password'] = $password;

            $user = $this->userService->createUserWithRole($userData, 'employee');

            $this->employeeRepository->update($employee->id, ['user_id' => $user->id]);

            $message = "Employee and user account created successfully.";

            return [
                'message' => $message,
                'employee' => $employee,
                'user' => $user,
                'attributes' => $newAttributes,
            ];
        }

        return $employee->load('user');

    }




    public function updateEmployee($id, array $data)
    {
        $newAttributes = $data['new_attributes'] ?? [];
        unset($data['new_attributes']);

        if (! $employee = $this->employeeRepository->update($id, $data)) {
            return false;
        }

        $this->attributesRepository
                ->storeAttributes($id,'employee', $newAttributes);

        return $employee;
    }

    public function deleteEmployee(int $id)
    {
        return $this->employeeRepository->delete($id);
    }

    public function forceDelete(int $id)
    {
        return $this->employeeRepository->forceDelete($id);
    }

    public function restore(int $id)
    {
        return $this->employeeRepository->restore($id);
    }
}
