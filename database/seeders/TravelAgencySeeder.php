<?php

namespace Database\Seeders;

use App\Models\TravelAgency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $latest = TravelAgency::latest('id')->first();
        $number = $latest ? ((int)str_replace('TA-', '', $latest->code)) + 1 : 1;
        $code = 'TA-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        TravelAgency::create([
            'company_name'  => 'African Queen',
            'email'         => 'AfricanQueen@gamil.com',
            'iate_code'     => 'abc',
            'status'        => 'active',
            'description'   => 'A leading travel agency providing luxury experiences in Africa.',
            'code'          => $code,
            "plan_id"     => 1,
        ]);
    }
}
