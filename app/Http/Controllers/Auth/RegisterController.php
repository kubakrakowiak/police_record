<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'email' => 'required', 'unique', 'string',
            'password' => 'required', 'string', 'confirmed',
            'name' => 'required', 'string',
            'last_name' => 'required', 'string',
        ]);

        $user = User::create([
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'name' => $fields['name'],
            'last_name' => $fields['last_name'],
            'grade_id' => 1
        ]);

        $token = $user->createToken('police_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response);
    }
}
