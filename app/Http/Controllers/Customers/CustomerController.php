<?php

namespace App\Http\Controllers\Customers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\StoreCustomerRequest;
use App\Http\Requests\Customers\UpdateCustomerRequest;
use App\Services\Customers\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getFees(Request $request, $customerId)
    {
        $itemId = $request->query('item_id');
        $destinationIATA = $request->query('destination');

        if (!$itemId || !$destinationIATA) {
            return response()->json(['message' => 'Missing parameters'], 400);
        }

        $result = $this->customerService->getCustomerFees($customerId, $itemId, $destinationIATA);

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], 404);
        }

        return response()->json($result);
    }

    public function getCustomers()
    {
        return response()->json(['customers' => $this->customerService->getCustomersData()]);
    }

    public function index()
    {
        return response()->json($this->customerService->getAllCustomers());
    }

    public function show($id)
    {
        return response()->json($this->customerService->getCustomerById($id));
    }

    public function storeCustomerGroup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:customer_groups,name',
            'description' => 'nullable|string|max:500',
        ]);

        $group = $this->customerService->storeGroup($validatedData);

        return response()->json([
            'message' => 'Customer group created successfully!',
            'data' => $group
        ], 201);
    }

    public function store(StoreCustomerRequest $request)
    {

        $customer = $this->customerService->createCustomer($request->validated());

        return response()->json([
            'message' => 'Customer created successfully.',
            'data' => $customer
        ], 201);
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerService->updateCustomer($id, $request->validated());

        return response()->json([
            'message' => 'Customer updated successfully.',
            'data' => $customer
        ]);
    }

    public function destroy($id)
    {
        return $this->customerService
                    ->deleteCustomer($id)

            ? response(['message'   => 'deleted successfully'], 410)
            : response(['error'     => 'not found!'], 404);
    }

    public function restore(int $id)
    {
        return response()
                ->json($this->customerService->restore($id));
    }

    public function forceDelete(int $id)
    {
        $this->customerService
                ->forceDelete($id);

        return response(410);
    }

}
