<?php

namespace App\Services\Customers;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Interfaces\Customers\CustomerEmployeeRepositoryInterface;
use App\Models\CustomerEmployee;
use App\Repositories\Customers\CustomerEmployeeRepository;
use App\Services\Customers\CustomerService;
use App\Repositories\Admin\UserRepository;


class CustomerEmployeeService
{
    protected CustomerEmployeeRepository $customerEmployeeRepository;
    protected UserRepository $userRepositoryInterface;
    protected CustomerService $customerSerivce;


    public function __construct(
        CustomerService                     $customerService,
        CustomerEmployeeRepository          $customerEmployeeRepository,
        UserRepositoryInterface             $userRepositoryInterface) {

        $this->customerSerivce              = $customerService;
        $this->customerEmployeeRepository   = $customerEmployeeRepository;
        $this->userRepositoryInterface      = $userRepositoryInterface;
    }

    public function getAllCustomerEmployees(int $customer)
    {
        return $this->customerEmployeeRepository
                    ->getAll($customer);
    }

    public function getCustomerEmployeeById(int $customer, int $customerEmployee)
    {
        return $this->customerEmployeeRepository->findById($customer, $customerEmployee);
    }

    public function createCustomerEmployee(int $customer, array $data)
    {
        return $this->customerEmployeeRepository
                    ->create($customer, $data);
    }

    public function updateCustomerEmployee(int $customer, int $id, array $data)
    {
        return $this->customerEmployeeRepository->update($customer, $id, $data);
    }

    public function deleteCustomerEmployee(int $customer, int $customerEmployee)
    {
        $this->customerEmployeeRepository->delete($customer, $customerEmployee);
    }

    public function forceDelete(int $id)
    {
        return $this->customerEmployeeRepository->forceDelete($id);
    }

    public function restore(int $id)
    {
        return $this->customerEmployeeRepository->restore($id);
    }
}
