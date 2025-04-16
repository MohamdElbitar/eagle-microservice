<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\TravelAgencies\ActivateTravelAgencyRequest;
use App\Http\Requests\TravelAgencies\CreateTravelAgencyRequest;
use App\Http\Requests\TravelAgencies\UpdateTravelAgencyRequest;
use App\Models\TravelAgency;
use App\Models\User;
use App\Services\TravelAgencies\TravelAgencyService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class TravelAgencyController extends Controller
{

    public function __construct(protected TravelAgencyService $travelAgencyService) {

    }

    public function index()
    {
        return response()->json($this->travelAgencyService->all());
    }

    public function pendingTravelAgance()
    {
        return response()->json($this->travelAgencyService->allPending());
    }
    public function create()
    {
        return response()->json($this->travelAgencyService->viewRegister());
    }

    public function store(CreateTravelAgencyRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'pending';

        $travelAgency = $this->travelAgencyService->create($validated);
        return response()->json([
            'message'       => 'travel agency created successfully',
            'travelAgency'  => $travelAgency,
        ], 201);
    }

    public function show(int $id)
    {
        return $this->travelAgencyService->show($id);
    }

    public function update(UpdateTravelAgencyRequest $request, int $id)
    {
        $travelAgency = $this->travelAgencyService->update($id, $request->validated());

        return response()->json([
            'message'       => 'travel agency updated successfully',
            'travelAgency'  => $travelAgency,
        ]);

    }

    public function activateAndCreateUser(int $id)
    {
        $travelAgency = $this->travelAgencyService->findById($id);

        if ($travelAgency->status !== 'pending') {
            return response()->json(['message' => 'Travel agency is already activated or has invalid status.'], 400);
        }

        // Update status
        $travelAgency->update([
            'status' => 'active',
        ]);


        return response()->json([
            'message' => 'Travel agency activated successfully.',
            'travelAgency' => $travelAgency,
        ], 201);
    }


    public function destroy( $id)
    {
        $this->travelAgencyService->delete($id);

        return response()->json(['message' => 'Deleted successfully'], 410);
    }
}
