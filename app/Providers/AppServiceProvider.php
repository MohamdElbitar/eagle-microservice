<?php

namespace App\Providers;

use App\Interfaces\Admin\AirportRepositoryInterface;
use App\Interfaces\Admin\CurrencyRepositoryInterface;
use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Interfaces\Admin\SectionRepositoryInterface;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Interfaces\Admin\UserRepositoryInterface;
use App\Interfaces\Customers\ContractRepositoryInterface;
use App\Interfaces\Customers\CustomerRepositoryInterface;
use App\Interfaces\Customers\ItemRepositoryInterface;
use App\Interfaces\AttributesRepositoryInterface;
use App\Interfaces\Employees\EmployeeContractRepositoryInterface;
use App\Interfaces\Employees\EmployeeRepositoryInterface;
use App\Repositories\Admin\AirportRepository;
use App\Repositories\Admin\UserRepository;
use App\Repositories\Customers\ContractRepository;
use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Customers\ItemRepository;
use App\Repositories\AttributesRepository;
use App\Repositories\Employees\EmployeeContractRepository;
use App\Repositories\Employees\EmployeeRepository;
use App\Repositories\TravelAgencies\TravelAgencyRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\TravelAgency\TravelAgencyInterface;
use App\Repositories\Admin\CurrencyRepository;
use App\Repositories\Admin\PlanRepository;
use App\Repositories\Admin\SectionRepository;
use App\Repositories\Admin\SettingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);

        $this->app->bind(EmployeeContractRepositoryInterface::class, EmployeeContractRepository::class);

        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);

        $this->app->bind(AirportRepositoryInterface::class, AirportRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(AttributesRepositoryInterface::class, AttributesRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);




    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
