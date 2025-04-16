<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\LeadSource;
use App\Services\Admin\SettingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    protected  $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }
    public function getAllLeadSources(): JsonResponse
    {
        return response()->json(LeadSource::all(), 200);
    }

    public function storeLeadSource(Request $request): JsonResponse
    {
        $request->validate(['name' => 'required|string|unique:lead_sources,name']);

        $leadSource = LeadSource::create(['name' => $request->name]);

        return response()->json([
            'message' => 'Lead source created successfully!',
            'data' => $leadSource
        ], 201);
    }


    public function updateSetting(Request $request, $travelAgencyId)
    {
        $validated = $request->validate([
            'name'         => 'sometimes|string',
            'company_name' => 'sometimes|string',
            'email'        => 'sometimes|email',
            'iate_code'    => 'sometimes|alpha|size:3',
            'description'  => 'nullable|string',
            'status'       => 'in:pending,active,suspended'
        ]);

        $agency = $this->settingService->updateSettings($travelAgencyId, $validated);

        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => $agency
        ]);
    }
}
