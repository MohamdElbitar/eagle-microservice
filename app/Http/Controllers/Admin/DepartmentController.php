<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Customers\DepartmentRequest;
use App\Models\CustomerEmployee;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;


class DepartmentController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Department::with('employees', 'customerEmployees')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        if ($department = Department::create($request->validated())) {
            return response([
                'departments'   => $department,
                'message'       => 'created succussfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $department)
    {
        $department = Department::with('customerEmployees')
            ->find($department);

        if (is_null($department)) {
            return response(['error' => 'not found!'], 404);
        }

        return response($department->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, int $department)
    {
        if ( ($department = Department::find($department))->update($request->validated()) )
        {
            return response([
                'department'    => $department->refresh(),
                'message'       => 'updated succussfully'
            ]);
        }

        return response(['error' => 'not found!'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $department)
    {
        return Department::find($department)?->delete()
            ? response(['message'   => 'deleted succussfully'], 410)
            : response(['error'     => 'not found!'], 404);
    }
}
