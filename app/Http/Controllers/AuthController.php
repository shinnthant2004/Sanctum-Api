<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\at;

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
            $token = $user->createToken('testing', ['admin']);
            return response()->json([
                'status' => 200,
                'message' => 'successfully Registered',
                'token' => $token->plainTextToken
            ]);
        }
    }
    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $user
        ]);
    }
    public function userlist()
    {
        if (!auth()->user()->tokenCan('admin')) {
            return response()->json([
                'status' => 403,
                'message' => 'unauthorized',
            ]);
        }
        $users = User::all();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $users
        ]);
    }
}