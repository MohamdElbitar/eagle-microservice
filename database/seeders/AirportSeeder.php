<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('data/airports.dat');
        if (!File::exists($filePath)) {
            return;
        }

        $file = fopen($filePath, 'r');
        while (($line = fgetcsv($file)) !== false) {
            if (count($line) < 8) {
                continue;
            }

            Airport::create([
                'name' => $line[1],
                'iata_code' => $line[4] !== "\\N" ? $line[4] : null,
                'icao_code' => $line[5] !== "\\N" ? $line[5] : null,
                'city' => $line[2],
                'country' => $line[3],
                'latitude' => $line[6],
                'longitude' => $line[7],
            ]);
        }

        fclose($file);
    }

    // public function run()
    // {
    //     // مسار الملف
    //     $filePath = storage_path('app/public/airports.csv');

    //     // قراءة البيانات
    //     $file = fopen($filePath, "r");
    //     $isHeader = true;

    //     while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    //         if ($isHeader) {
    //             $isHeader = false; // تخطي العنوان
    //             continue;
    //         }

    //         DB::table('airports')->insert([
    //             'name'       => $data[2], // العمود الثالث في CSV
    //             'iata_code'  => $data[0], // العمود الأول في CSV
    //             'icao_code'  => $data[1], // العمود الثاني في CSV
    //             'city'       => $data[9], // العمود العاشر في CSV
    //             'country'    => $data[8], // العمود التاسع في CSV
    //             'latitude'   => $data[3], // العمود الرابع في CSV
    //             'longitude'  => $data[4], // العمود الخامس في CSV
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }

    //     fclose($file);
    // }
}
