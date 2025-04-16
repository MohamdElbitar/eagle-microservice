<?php

namespace App\Http\Controllers\Customers;
use App\Http\Controllers\Controller;
use App\Http\Requests\employees\CreateCustomerEmployeeRequest;
use App\Http\Requests\employees\UpdateCustomerEmployeeRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Services\Customers\CustomerEmployeeService;
use App\Services\Customers\CustomerService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerEmployee;
use App\Models\Customer;
use App\Interfaces\Customers\CustomerRepositoryInterface;;


class CustomerEmployeeController extends Controller
{

    public function __construct(protected CustomerEmployeeService $customerEmployeeService)
    {
    }

    public function index(int $customer)
    {
        return $this->customerEmployeeService
                    ->getAllCustomerEmployees($customer);
    }

    public function show(int $customer, int $customerEmployee)
    {
        if (is_null($user = $this->customerEmployeeService
                ->getCustomerEmployeeById($customer, $customerEmployee))) {

            return response(status: 404);
        }

        return response()->json($user);
    }

    public function store(CreateCustomerEmployeeRequest $request, int $customer)
    {
        return $this->customerEmployeeService
                    ->createCustomerEmployee($customer, $request->validated());
    }

    public function update(UpdateCustomerEmployeeRequest $request, int $customer, int $customerEmployee)
    {
        $customerEmployee = $this->customerEmployeeService
                ->updateCustomerEmployee($customer, $customerEmployee, $request->validated());

        return response([
            'message'   => 'Customer employee updated successfully',
            'data'      => $customerEmployee,
        ]);
    }

    public function destroy(int $customer, int $customerEmployee)
    {
        $this->customerEmployeeService
                ->deleteCustomerEmployee($customer, $customerEmployee);

        return response()->json(['message' => 'Customer employee deleted successfully'])
                            ->setStatusCode(410);
    }

    public function restore(int $id)
    {
        return response()
                ->json($this->customerEmployeeService->restore($id));
    }

    public function forceDelete(int $id)
    {
        $this->customerEmployeeService
                ->forceDelete($id);

        return response(410);
    }
}
