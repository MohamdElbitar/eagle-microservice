<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AirportRepositoryInterface;
use App\Models\Airport;

class AirportRepository implements AirportRepositoryInterface
{
    public function findByIataCode($iataCode)
    {
        return Airport::where('iata_code', $iataCode)->first();
    }

    public function getAllAirports()
    {
        return Airport::all();
    }
}
