<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\AirportRepositoryInterface;
class AirportService
{
    protected $airportRepository;

    public function __construct(AirportRepositoryInterface $airportRepository)
    {
        $this->airportRepository = $airportRepository;
    }

    public function getAirportType($iataCode)
    {
        $airport = $this->airportRepository->findByIataCode($iataCode);

        if (!$airport) {
            return null;
        }

        return ($airport->country === 'Egypt') ? 'Domestic' : 'International';
    }

    public function getAllAirports()
    {
        return $this->airportRepository->getAllAirports();


    }
}
