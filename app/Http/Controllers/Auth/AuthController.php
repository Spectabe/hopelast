<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Accesso effettuato'
            ], 201);
        }

        return response()->json([
            'message' => 'Credenziali non valide'
        ], 401);
    }


    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:70',
            'email' => 'required|string|email|max:254|unique:users',
            'password' => 'required|string|min:8|max:64',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
        ]);

        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => "Registrazione effettuata"
        ], 201);
    }

public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "Logout effettuato correttamente",
        ], 201);
    }

    public function checkToken(Request $request)
{
    $user = $request->user();

    if ($user && $user->currentAccessToken()->tokenable_id === $user->id) {
        return response()->json(['message' => 'Token valido'], 201);
    }

    return response()->json(['error' => 'Token non valido'], 401);
}


}
