<?php

use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TravelAgencyController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Employees\EmployeeContractController;
use App\Http\Controllers\Employees\EmployeeController;

use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\Customers\CustomerEmployeeController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Customers\ContractController;

use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SectionController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;



//AUthentication Routes

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/register-travel-agencies', [TravelAgencyController::class, 'create'])->name('travel-agencies.register');
Route::post('/register-travel-agencies', [TravelAgencyController::class, 'store'])->name('travel-agencies.register');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    // Admin Eagle Management
    Route::middleware(['role:super_admin'])->group(function () {
        Route::apiResource('/users', UserController::class);
        Route::apiResource('currencies', CurrencyController::class);
        Route::apiResource('plans', PlanController::class);
        Route::apiResource('sections', SectionController::class);
        // Route::apiResource('travel-agencies', TravelAgencyController::class);
        Route::get('/pending-travel-agencies', [TravelAgencyController::class, 'pendingTravelAgance'])->name('travel-agencies.pending');
        Route::post('/travel-agencies/{id}/activate', [TravelAgencyController::class, 'activateAndCreateUser']);
        Route::get('/admin-dashboard', function () {
            return "Welcome Admin";
        });
        Route::prefix('lead-sources')->group(function () {
            Route::get('/', [SettingController::class, 'getAllLeadSources']);
            Route::post('/', [SettingController::class, 'storeLeadSource']);
        });
    });


    // Employees Routes
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/employee-dashboard', function () {
            return "Welcome Employee";
        });
    });



    // Travel Agency Admin Routes
    Route::middleware(['role:travel_agency_admin'])->group(function () {
        Route::apiResource('employees', EmployeeController::class);
        // Route::apiResource('employee-contracts', EmployeeContractController::class);
        Route::get('employees-contracts', [EmployeeContractController::class ,'index']);
        Route::post('employees/{employee}/contracts', [EmployeeContractController::class, 'store']);
        Route::put('/employee-contracts/{id}', [EmployeeContractController::class, 'update']);
        //settings
        Route::put('/travel-agencies/{travelAgencyId}/settings', [SettingController::class, 'updateSetting']);
    });

    // Customers Routes
    Route::controller(CustomerController::class)
            ->group(function () {

                Route::apiResource('customers', CustomerController::class);

                Route::patch('customers/{id}/restore', 'restore');
                Route::delete('customers/{id}/force', 'forceDelete');
                Route::post('/customers/group', [CustomerController::class, 'storeCustomerGroup']);
                Route::post('customers/{customer}/item-markups', [ItemController::class, 'addMarkups']);
    });

    // Contracts Routes
    Route::middleware(['role:travel_agency_admin'])->group(function () {
        Route::controller(ContractController::class)
                ->group(function () {
                    Route::apiResource('contracts', ContractController::class);
                    Route::prefix('contracts')
                            ->group(function () {

                                Route::patch('{id}/restore', 'restore');
                                Route::delete('{id}/force', 'forceDelete');

                                Route::post('{contract}/item-fees', [ItemController::class, 'addFees']);
                            });
                });
    });

    // Items Routes
    Route::controller(ItemController::class)
            ->group(function () {

                Route::apiResource('items', ItemController::class);

                Route::post('items/{item}/types', [ItemController::class, 'createTypes']);
                Route::put('items/types/{type}', [ItemController::class, 'updateType']);
                Route::delete('items/types/{type}', [ItemController::class, 'deleteType']);

                Route::patch('items/{id}/restore', 'restore');
                Route::delete('items/{id}/force', 'forceDelete');
    });



    // Attributes Routes
    Route::apiResource('attributes', AttributeController::class);

    // Customer Employees Routes
    Route::apiResource('customers.employees', CustomerEmployeeController::class);

    // Departments
    Route::apiResource('departments', DepartmentController::class);
});


//old erb code
// Route::prefix('customers')->group(function () {

    Route::get('customer/detailed', [CustomerController::class, 'getCustomers']);
    Route::get('customer/{customerId}/fees', [CustomerController::class, 'getFees']);

// });

Route::get('/airports', [CustomerController::class, 'fetchAirports']);

Route::get('/allAirports', [AirportController::class, 'getAllAirports']);

