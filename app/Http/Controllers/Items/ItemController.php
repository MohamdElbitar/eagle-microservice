<?php

namespace App\Http\Controllers\Items;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Customers\{CustomerService, ContractService, ItemService};
use App\Http\Requests\Customers\{CreateItemRequest, UpdateItemRequest, AddMarkupsRequest, AddFeesRequest};



class ItemController extends Controller
{

    public function __construct(
        protected ItemService $itemService,
        protected CustomerService $customerService,
        protected ContractService $contractService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        return response()->json($this->itemService->getAllItems());
    }

    public function show(int $id)
    {
        return ! is_null($item = $this->itemService->getItemById($id))
                    ? response(['item'  => $item]) 
                    : response(['error' => 'not found!'], 404);
    }

    public function store(CreateItemRequest $request)
    {
        $item = $this->itemService
            ->createItem($request->validated());

        return response()->json($item, 201);
    }

    public function update(UpdateItemRequest $request, $id)
    {
        return ( $item = $this->itemService->updateItem($id, $request->validated()) )
            ? response(['message'   => 'updated succussfully', 'item' => $item])
            : response(['error'     => 'not found!'], 404);
    }

    public function destroy(int $id)
    {
        return $this->itemService->deleteItem($id)
            ? response(['message'   => 'deleted succussfully'], 410)
            : response(['error'     => 'not found!'], 404);
    }

    public function restore(int $id)
    {
        return response()
                ->json($this->itemService->restore($id));
    }

    public function forceDelete(int $id)
    {
        $this->itemService
                ->forceDelete($id);

        return response(410);
    }

    public function addMarkups(AddMarkupsRequest $request, int $customer)
    {
        $this->customerService
                ->addMarkups($customer, $request->validated()['types'] ?? []);

        return response(status: 200);
    }

    public function addFees(AddFeesRequest $request, int $contract)
    {
        $this->contractService
                ->addFees($contract, $request->validated()['types'] ?? []);

        return response(status: 200);
    }

    public function createTypes(int $item, Request $request)
    {
        $validated = $request->validate([
            'types'         => 'required|array',
            'types.*.name'  => 'required|string',
        ]);

        return $this->itemService
                    ->createTypes($item, $validated['types']);
    }

    public function updateType(int $typeID, Request $request)
    {
        return $this->itemService
            ->updateItemType($typeID, $request->validate(['name' => 'required|string']));
    }

    public function deleteType(int $typeID)
    {
        return $this->itemService->deleteItemType($typeID);
    }
}
