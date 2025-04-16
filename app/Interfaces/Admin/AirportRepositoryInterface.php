<?php

namespace App\Interfaces\Admin;

interface AirportRepositoryInterface
{
    public function findByIataCode($iataCode);
    public function getAllAirports();


}
