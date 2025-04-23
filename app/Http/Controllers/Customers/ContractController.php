<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Services\Customers\ContractService;

use App\Http\Requests\Customers\Contract\{StoreContractRequest, UpdateContractRequest};


class ContractController extends Controller
{

    public function __construct(protected ContractService $contractService)
    {
    }

    public function index()
    {
        return response()->json($this->contractService->getContracts());
    }

    public function store(StoreContractRequest $request)
    {
        $contract = $this->contractService
            ->createContract($request->validated());

        return response()->json($contract, 201);
    }

    public function show($id)
    {
        return response()->json($this->contractService->getContract($id));
    }

    public function update(UpdateContractRequest $request, int $id)
    {
        return response()->json($this->contractService->updateContract($id, $request->validated()) );
    }

    public function destroy(int $id)
    {
        return response()->json($this->contractService->deleteContract($id));
    }

    public function restore(int $id)
    {
        return response()->json($this->contractService->restore($id));
    }
    public function forceDelete(int $id)
    {
        $this->contractService
                ->forceDelete($id);

        return response(status: 410);
    }
}
