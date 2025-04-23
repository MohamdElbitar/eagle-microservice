<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $super_admin = Role::create(['name' => 'super_admin']);
        $travel_agency_admin = Role::create(['name' => 'travel_agency_admin']);
        $employee = Role::create(['name' => 'employee']);
        // $customer = Role::create(['name' => 'customer']);
        $customer_admin=Role::create(['name' => 'customer_admin']);
        $customer_employee=Role::create(['name' => 'customer_employee']);

        // Define modules
        $modules = [
            'users',
            'customers',
            'employees',
            'customer employees',
            'items',
            'item types',
            'contracts'
        ];

        // Define permission actions
        $actions = ['create', 'edit', 'delete', 'view', 'manage'];

        $permissions = [];

        // Generate permissions for each module
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = "$action $module";
            }
        }

        // Create permissions in the database
        foreach ($permissions as $permission) {
            // Permission::firstOrCreate(['name' => $permission, ['guard_name' => 'web']]);
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $super_admin->givePermissionTo(Permission::all());
        $travel_agency_admin->givePermissionTo(Permission::all());
        $employee->givePermissionTo([
            'view customers', 'create customers','edit customers','delete customers', 'view employees', 'manage contracts' ,'create contracts'
        ]);

        $customer_employee->givePermissionTo(['view items', 'view item types']);
    }
}
