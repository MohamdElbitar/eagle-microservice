<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TravelAgency;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'role' => 'required|string',
            'travel_agency_id' => 'nullable|exists:travel_agencies,id'
        ]);
            // Check travel agency status if travel_agency_id is provided
        if (!empty($validated['travel_agency_id'])) {
            $travelAgency = TravelAgency::find($validated['travel_agency_id']);

            if ($travelAgency->status === 'pending') {
                return response()->json([
                    'message' => 'Cannot create user: Travel agency is pending approval.'
                ], 422);
            }
        }
            // Hash the password before saving
            $validated['password'] = bcrypt($validated['password']);

            $user = User::create($validated);

        return response()->json($user, 201);
    }

}
