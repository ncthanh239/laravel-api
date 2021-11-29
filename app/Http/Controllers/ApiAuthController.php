<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(Request $request) {
        // $validator = Validator::make($request->all(), [
        //     'email' => ['required', 'string', 'email', 'max:255'],
        //     'password' => ['required', 'string', 'min:5'],
        // ]);
        // if ($validator->fails()) {
        //     $response = $validator->messages();
        //     return response()->json(['message' => $response], 422);
        // } else {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                $user = User::whereEmail($request->email)->first();
                $user->token = $user->createToken('App')->accessToken;
                return response()->json(['token' => $user->token]);
            }
        // }
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
        ]);
        if ($validator->fails()) {
            $response = $validator->messages();
            return response()->json(['message' => $response], 422);
        } else {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json($user);
        }
    }

    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'Logout successfully!']);
    }

    public function userInfo(Request $request) {
        return response()->json($request->user('api'));
    }
}
