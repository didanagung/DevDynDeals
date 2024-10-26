<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $success['token'] = $user->createToken('user_login')->plainTextToken;
        $success['email'] = $user->email;
        $success['name'] = $user->name;
        $success['norec'] = $user->id;
        $success['role'] = $user->role;

        return response()->json([
            'status' => 200,
            'message' => 'Login Success',
            'data' => $success
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        $cek_user = User::all();
        $role_user = count($cek_user) > 0 ? 2 : 1;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'statusenabled' => true,
            'role' => $role_user
        ]);

        $success['token'] = $user->createToken('user_login')->plainTextToken;
        $success['email'] = $user->email;
        $success['name'] = $user->name;
        $success['norec'] = $user->id;
        $success['role'] = $user->role;

        return response()->json([
            'success' => 201,
            'message' => 'Register Success',
            'data' => $success
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout Success'
        ]);
    }
}
