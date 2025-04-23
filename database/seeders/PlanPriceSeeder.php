<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Plan;
use App\Models\PlanPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $usdCurrency = Currency::where('code', 'USD')->first();
        $egpCurrency = Currency::where('code', 'EGP')->first();

        $basicPlan = Plan::where('name', 'Basic Plan')->first();
        $premiumPlan = Plan::where('name', 'Premium Plan')->first();

        PlanPrice::create([
            'plan_id' => $basicPlan->id,
            'currency_id' => $usdCurrency->id,
            'price' => 100.00
        ]);

        PlanPrice::create([
            'plan_id' => $premiumPlan->id,
            'currency_id' => $egpCurrency->id,
            'price' => 1500.00
        ]);
    }
}
