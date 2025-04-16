<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CurrencySeeder::class,
            PlanSeeder::class,
            PlanPriceSeeder::class,
            BusinessApplicationSeeder::class,
            SectionSeeder::class,
            AirportSeeder::class,
            TravelAgencySeeder::class,
            RoleSeeder::class,

        ]);


//create super admin
        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin'
        ]);
    // Create an Admin User
        $travel_agency_admin = User::create([
            'name' => 'African Queen Admin',
            'email' => 'african_queen_admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'travel_agency_admin',
            'travel_agency_id' => 1

        ]);
        $super_admin->assignRole('super_admin');
        $role = Role::where('name', 'super_admin')->first();
        $super_admin->givePermissionTo($role->permissions);

        $travel_agency_admin->assignRole('travel_agency_admin');
        $role = Role::where('name', 'travel_agency_admin')->first();
        $travel_agency_admin->givePermissionTo($role->permissions);
    }
}
