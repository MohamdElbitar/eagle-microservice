<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
            // Seed sample plans
            Plan::create([
                'name' => 'Basic Plan',
                'description' => 'A basic plan for small agencies.',
            ]);

            Plan::create([
                'name' => 'Premium Plan',
                'description' => 'A standard plan for medium-sized agencies.',
            ]);
    }
}
