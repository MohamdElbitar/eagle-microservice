<?php

namespace App\Http\Controllers\Employees;
use App\Http\Controllers\Controller;

use App\Http\Requests\Employees\StoreEmployeeContractRequest;
use App\Http\Requests\Employees\UpdateEmployeeContractRequest;
use App\Services\Employees\EmployeeContractService;
use App\Models\Employee;

class EmployeeContractController extends Controller
{
    protected $contractService;

    public function __construct(EmployeeContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function index()
    {
        return $this->contractService->getAllContracts();
    }

    public function store(StoreEmployeeContractRequest $request, $employee_id)
    {
        $employee = Employee::find($employee_id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $data = array_merge($request->validated(), ['employee_id' => $employee->id]);
        return $this->contractService->createContract($data);
    }


    public function show(int $id)
    {
        return $this->contractService->getContractById($id);
    }

    public function update(UpdateEmployeeContractRequest $request, int $id)
    {
        $this->contractService->updateContract($id, $request->validated());

        return response(['message' => 'Updated successfully!']);
    }

    public function destroy(int $id)
    {
        $this->contractService->deleteContract($id);

        return response(['message' => 'Deleted successfully!']);
    }
}
