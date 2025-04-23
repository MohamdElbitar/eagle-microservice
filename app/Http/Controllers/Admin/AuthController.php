<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // User Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // User Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $allowedRoles = ['super_admin','travel_agency_admin', 'employee', 'customer_admin', 'customer_employee'];

        if (!$user->role || !in_array($user->role, $allowedRoles)) {
            return response()->json([
                'message' => 'Access denied. You do not have permission to log in.',
            ], 403);
        }
            //  Check travel agency status if user is travel agency admin
        if ($user->role !== 'super_admin') {
            $travelAgency = $user->travelAgency;
            if (!$travelAgency || $travelAgency->status !== 'active') {
                return response()->json([
                    'status'  => $travelAgency?->status ?? 'not_found',
                    'message' => 'Your travel agency account is not active yet.',
                ], 403);
            }
        }


        $permissions = $user->permissions()->pluck('name');
        $token = $user->createToken('auth_token')->plainTextToken;

        $userData = [
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'role'        => $user->role,
            'permissions' => $permissions,
        ];

        if ($user->role === 'travel_agency_admin' && $user->travelAgency && $user->travelAgency->plan) {
            $userData['plan'] = $user->travelAgency->plan;
            $userData['business_applications'] = $user->travelAgency->plan->businessApplications()->with('sections')->get();
        }

        return response()->json([
            'message' => 'Login successful.',
            'user'    => $userData,
            'token'   => $token,
        ]);
    }

    
    // User Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
