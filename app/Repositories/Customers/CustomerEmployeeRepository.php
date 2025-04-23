<?php

namespace App\Repositories\Customers;

use App\Interfaces\Customers\CustomerEmployeeRepositoryInterface;
use App\Models\CustomerEmployee;
use App\Services\Customers\CustomerService;
use App\Services\Admin\UserService;
use App\Models\User;


class CustomerEmployeeRepository implements CustomerEmployeeRepositoryInterface
{
    public function __construct(
        protected CustomerService $customerService,
        protected UserService $userService)
    {

    }
    public function getAll(int $customer)
    {
        return CustomerEmployee::with('user')
                ->where('customer_id', $customer)
                ->get();
    }

    public function findById(int $customer, int $customerEmployee)
    {
        return CustomerEmployee::with('user')
                ->find($customerEmployee);
    }

    public function create(int $customer, array $data)
    {
        $user = $this->userService->createUserWithRole($data, 'customer_employee');
        $data = collect($data)
                    ->except( 'password');

        $this->customerService
                ->getCustomerById($customer)
                ->employees()
                ->attach($user->id, $data->toArray());

        return $user;
    }

    public function update(int $customer, int $customerEmployee, array $data)
    {
        ($customerEmployee = CustomerEmployee::find($customerEmployee))
            ->user()
            ->update($data);

        return $customerEmployee;
    }

    public function delete(int $customerId, int $customerEmployeeId)
    {
        $customerEmployee = CustomerEmployee::where('id', $customerEmployeeId)
        ->where('customer_id', $customerId)
        ->firstOrFail();
        $this->userService->delete($customerEmployee->user_id);
        $customerEmployee->delete();
    }

    public function restore(int $customerEmployee)
    {
        return CustomerEmployee::onlyTrashed()
                ->findOrFail($customerEmployee)
                ->restore();
    }

    public function forceDelete(int $customerEmployee)
    {
        return CustomerEmployee::onlyTrashed()
                ->findOrFail($customerEmployee)
                ->forceDelete();
    }
}
