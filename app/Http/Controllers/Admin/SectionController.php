<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\Admin\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function index()
    {
        return response()->json($this->sectionService->getAllSections());
    }
    public function show($id)
    {
        return response()->json($this->sectionService->getSectionById($id));
    }

    public function getSectionsByPlan($planId)
    {
        return response()->json($this->sectionService->getSectionsByPlan($planId));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        return response()->json([
            'section' => $this->sectionService->createSection($validated),
            'message' => 'Section created successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        return response()->json([
            'section' => $this->sectionService->updateSection($id, $validated),
            'message' => 'Section updated successfully'
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => $this->sectionService->deleteSection($id) ? 'Section deleted successfully' : 'Failed to delete section'
        ]);
    }
}

