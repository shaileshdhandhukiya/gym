<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new user.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|min:10|max:15|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female,Other',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Upload profile image if provided
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'address' => $request->address,
            'gender' => $request->gender,
            'profile_image' => $profileImagePath,
        ]);

        return response()->json(['user' => $user], 201);
    }

    /**
     * Retrieve all users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Retrieve a single user.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update a user.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'sometimes|required|string|min:10|max:15|unique:users,phone_number,' . $user->id,
            'password' => 'sometimes|required|string|min:6|confirmed',
            'role' => 'sometimes|required|string',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female,Other',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $profileImagePath;
        }

        // Update user fields
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone_number = $request->phone_number ?? $user->phone_number;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role ?? $user->role;
        $user->address = $request->address ?? $user->address;
        $user->gender = $request->gender ?? $user->gender;

        $user->save();

        return response()->json(['user' => $user], 200);
    }

    /**
     * Delete a user.
     */
    public function destroy($id)
    {

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
