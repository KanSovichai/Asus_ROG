<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    function createUser(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }
    function getUserData()
    {   
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'message' => 'User data retrieved successfully',
            'users' => $users,
            ], 200);
    }

    function changeRole($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Toggle the user's role
        $user->role = ($user->role === 1) ? 0 : 1;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User role updated successfully',
            'user' => $user,
        ], 200);
    }

    function deleteUser($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully',
        ], 200);
    }

    function updateUser(Request $request, $id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
        ], 200);
    }
}
