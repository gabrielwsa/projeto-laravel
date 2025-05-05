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

}