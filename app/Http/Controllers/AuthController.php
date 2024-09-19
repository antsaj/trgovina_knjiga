<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Registracija
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Hashiraj lozinku
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Registracija uspješna',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Prijava
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Neispravni podaci za prijavu'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        // Provjerava je li korisnik admin
        $isAdmin = $user->email === 'kristinakulic@gmail.com';

        return response()->json([
            'message' => 'Prijava uspješna',
            'user' => $user,
            'token' => $token,
            'isAdmin' => $isAdmin, // Dodajemo ovaj field
        ], 200);
    }
}
