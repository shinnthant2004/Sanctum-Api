<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make(request()->password);
        $user->save();
        $token = $user->createToken('testing');
        return response()->json([
            'status' => 200,
            'message' => 'successfully Registered',
            'token' => $token->plainTextToken
        ]);
    }
    public function login()
    {
        if (Auth::attempt(['email' => request()->email, 'password' => request()->password])) {
            $user = auth()->user();
            $token = $user->createToken('testing');
            return response()->json([
                'status' => 200,
                'message' => 'successfully Registered',
                'token' => $token->plainTextToken
            ]);
        }
    }
}