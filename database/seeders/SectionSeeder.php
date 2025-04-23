<?php


namespace Database\Seeders;

use App\Models\Section;
use App\Models\Plan;
use App\Models\BusinessApplication;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $crm = BusinessApplication::where('name', 'CRM')->first();
        $hr = BusinessApplication::where('name', 'HR')->first();
        $billing = BusinessApplication::where('name', 'Billing')->first();

        $crmSections = [
            Section::create(['name' => 'Customers', 'business_application_id' => $crm->id]),
            Section::create(['name' => 'Leads', 'business_application_id' => $crm->id]),
        ];

        $hrSections = [
            Section::create(['name' => 'Employees', 'business_application_id' => $hr->id]),
            Section::create(['name' => 'Attendance', 'business_application_id' => $hr->id]),
        ];

        $billingSections = [
            Section::create(['name' => 'Invoices', 'business_application_id' => $billing->id]),
            Section::create(['name' => 'Payments', 'business_application_id' => $billing->id]),

        ];

        $basicPlan = Plan::where('name', 'Basic Plan')->first();
        $premiumPlan = Plan::where('name', 'Premium Plan')->first();

        $basicPlan->businessApplications()->attach([$crm->id, $billing->id]);
        $premiumPlan->businessApplications()->attach([$crm->id, $hr->id, $billing->id]);
    }
}

