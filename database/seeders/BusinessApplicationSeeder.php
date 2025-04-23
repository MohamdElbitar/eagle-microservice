<?php


namespace Database\Seeders;

use App\Models\BusinessApplication;
use Illuminate\Database\Seeder;

class BusinessApplicationSeeder extends Seeder
{
    public function run(): void
    {
        BusinessApplication::create(['name' => 'CRM']);
        BusinessApplication::create(['name' => 'HR']);
        BusinessApplication::create(['name' => 'Billing']);
    }
}
