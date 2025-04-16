<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\Admin\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        return response()->json($this->currencyService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|max:3',
            'symbol' => 'required|string|max:5',
        ]);

        return response()->json($this->currencyService->create($validated));
    }

    public function show($id)
    {
        return response()->json($this->currencyService->getById($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'code' => 'sometimes|string|max:3',
            'symbol' => 'sometimes|string|max:5',
        ]);

        return response()->json($this->currencyService->update($id, $validated));
    }

    public function destroy($id)
    {
        $this->currencyService->delete($id);
        return response()->json(['message' => 'Currency deleted.']);
    }
}
