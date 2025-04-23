<?php

namespace App\Http\Controllers\Employees;
use App\Http\Controllers\Controller;

use App\Http\Requests\Employees\CreateEmployeeRequest;
use App\Http\Requests\Employees\UpdateEmployeeRequest;
use App\Services\Employees\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\Middleware;



class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        // $this->middleware('role:admin')->only(['store', 'update', 'destroy']);
        // $this->middleware(['role_or_permission:read-building'])->only(['index']);
        $this->employeeService = $employeeService;
    }

    #[Middleware(['role:admin', 'role:employee'])]
    public function index()
    {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            return response()->json([
                // 'user_roles' => $user->getRoleNames(),
                // 'permissions' => $user->getAllPermissions(),
                'employees' => $this->employeeService->getAllEmployees(),
            ]);
    }

    public function show($id)
    {
        if (! is_null($employee = $this->employeeService->getEmployeeById($id)) ) {
            return response()->json($employee);
        }

        return response(['message' => 'not found!'], 404);
    }

    public function store(CreateEmployeeRequest $request)
    {
        $employee = $this->employeeService->createEmployee($request->validated());

        return response()->json([
            'message'   => 'Employee created successfully.',
            'data'      => $employee
        ], 201);
    }

    public function update(UpdateEmployeeRequest $request, int $id)
    {
        $employee = $this->employeeService
            ->updateEmployee($id, $request->validated());

        return $employee
            ? response(['employee'  => $employee, 'message' => 'updated successfully'])
            : response(['error'     => 'not found!'], 404);
    }

    public function destroy($id)
    {
        if ($this->employeeService->deleteEmployee($id)) {
            return response(['message' => 'deleted successfully'], 410);
        }

        return response(['error' => 'not found!'], 404);
    }

    public function restore(int $id)
    {
        return response()
                ->json($this->employeeService->restore($id));
    }

    public function forceDelete(int $id)
    {
        $this->employeeService
                ->forceDelete($id);

        return response(410);
    }
}
