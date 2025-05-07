<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        try {
            $users = User::all();
            
            return response()->json([
                'users' => $users,
                'current_user' => auth('api')->user()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            $currentUser = auth('api')->user();
            
            if ($currentUser->id != $id) {
                return response()->json(['error' => 'Unauthorized. You can only view your own profile.'], 403);
            }
            
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        return response()->json(['error' => 'Use the register endpoint to create a new user'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            
            $user = User::find($id);
            
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            $currentUser = auth('api')->user();
            
            if ($currentUser->id != $id) {
                return response()->json(['error' => 'Unauthorized. You can only update your own profile.'], 403);
            }
            
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'password' => 'sometimes|string|min:6',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            $currentUser = auth('api')->user();
            
            if ($currentUser->id != $id) {
                return response()->json(['error' => 'Unauthorized. You can only delete your own profile.'], 403);
            }
            
            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}