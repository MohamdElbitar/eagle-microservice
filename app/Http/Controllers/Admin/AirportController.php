<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\Admin\AirportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AirportController extends Controller
{
    //

    protected $airportService;

    public function __construct(AirportService $airportService)
    {
        $this->airportService = $airportService;
    }
    public function getAllAirports()
    {
        return response()->json(['airports' => $this->airportService->getAllAirports()]);
    }

    private $apiUrl = "https://api.aviationstack.com/v1/airports";
    private $apiKey = "834a7e8153bed5d7cf05443d8a1be59d"; //

    public function fetchAirports()
    {
        $response = Http::get($this->apiUrl, [
            'access_key' => $this->apiKey
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch airports'], 500);
        }
    }
}
