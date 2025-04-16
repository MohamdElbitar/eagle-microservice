<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PlanPrice;
use App\Services\Admin\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    public function index()
    {
        return response()->json($this->planService->getAllPlans());
    }

    public function show($id)
    {
        return response()->json($this->planService->getPlanById($id));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prices' => 'required|array|min:1',
            'prices.*.currency_id' => 'required|exists:currencies,id',
            'prices.*.price' => 'required|numeric|min:0',
            'business_application_ids' => 'nullable|array',
            'business_application_ids.*' => 'exists:business_applications,id',
        ]);

        try {
            // Prepare plan data
            $planData = [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null
            ];

            // Create basic plan
            $plan = $this->planService->createPlan($planData);

            // Add currency prices
            foreach ($validated['prices'] as $priceData) {
                $plan->prices()->create([
                    'currency_id' => $priceData['currency_id'],
                    'price' => $priceData['price']
                ]);
            }

            // Attach business applications
            if (!empty($validated['business_application_ids'])) {
                $plan->businessApplications()->sync($validated['business_application_ids']);
            }

            return response()->json([
                'success' => true,
                'plan' => $plan->load(['prices.currency', 'businessApplications.sections']),
                'message' => 'Plan created successfully with multiple currency prices'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'prices' => 'sometimes|array|min:1',
            'prices.*.currency_id' => 'required_with:prices|exists:currencies,id',
            'prices.*.price' => 'required_with:prices|numeric|min:0',
            'business_application_ids' => 'nullable|array',
            'business_application_ids.*' => 'exists:business_applications,id',
        ]);

        try {
            // Get the plan
            $plan = $this->planService->getPlanById($id);
            // Prepare update data
            $updateData = [
                'name' => $validated['name'] ?? $plan->name,
                'description' => $validated['description'] ?? $plan->description
            ];

            // Update basic plan info
            $this->planService->updatePlan($id, $updateData);

            if (isset($validated['prices'])) {
                foreach ($validated['prices'] as $priceData) {
                    $plan->prices()->updateOrCreate(
                        ['currency_id' => $priceData['currency_id']],
                        ['price' => $priceData['price']]
                    );
                }
            }

            // Sync business applications if provided
            if (array_key_exists('business_application_ids', $validated)) {
                $plan->businessApplications()->sync($validated['business_application_ids']);
            }

            return response()->json([
                'success' => true,
                'plan' => $plan->fresh()->load(['prices.currency', 'businessApplications.sections']),
                'message' => 'Plan updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => $this->planService->deletePlan($id) ? 'Plan deleted successfully' : 'Failed to delete plan'
        ]);
    }
}
