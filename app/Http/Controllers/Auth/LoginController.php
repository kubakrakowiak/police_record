<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('police_record')->plainTextToken;
            $success['name'] =  $user->name;
            $success['lastName'] =  $user->last_name;
            $success['email'] =  $user->email;
            $success['grade'] =  $user->grade;
            $success['job'] =  $user->grade->job;
            $success['permission'] =  $user->permission;
            return response()->json($success, 201);
        } throw ValidationException::withMessages([
            'email' => ['Provided credentials are incorrect']
    ]);
    }

    public function logout()
    {
        try {
            Session::flush();
            Auth::user()->tokens()->delete();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function getUser()
    {
        if($user = Auth::user()){
            $success['token'] =  $user->createToken('police_record')->plainTextToken;
            $success['name'] =  $user->name;
            $success['lastName'] =  $user->last_name;
            $success['email'] =  $user->email;
            $success['job'] =  $user->grade->job;
            $success['grade'] =  $user->grade;
            $success['permission'] =  $user->permission;
            return response()->json($success, 200);
        }
        return false;
    }


}
