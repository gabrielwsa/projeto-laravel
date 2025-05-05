<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {
                $token = $request->user()->createToken('token-name');
                return response()->json(['token' => $token->plainTextToken]);
            }

            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Autenticar o usuário
            Auth::login($user);
            
            // Criar token após autenticar
            $token = $user->createToken('token-name');

            return response()->json([
                'message' => 'Usuario creado con exito',
                'token' => $token->plainTextToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Usuario deslogueado con exito',
        ], 200);
    }

}