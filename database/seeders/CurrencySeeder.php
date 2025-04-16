<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Currency::create(['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$']);
        Currency::create(['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€']);
        Currency::create(['code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => '£']);
    }
}
