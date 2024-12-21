<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        if ($this->checkUserAuth($request->email)) {
            return $this->responseMessage(false, 'User is looged in', null, 409);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5'
        ]);

        if ($validator->fails()) {
            return $this->responseMessage(false, $validator->errors(), null, 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        $token = $user->createToken($user->email.'_token')->plainTextToken;
        return $this->responseMessage(true, 'new user registered', 
        ['user' => $user, 'token' => $token], 200);
    }

    public function login(Request $request){
        if ($this->checkUserAuth($request->email)) {
            return $this->responseMessage(false, 'User is looged in', null, 409);
        }
        //Valdiacio de dades
        //comprovacio del login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user -> createToken('Api-Token')->plainTextToken;
            return $this->responseMessage(true, 'Login succesfull', ['token' => $token], 200);
        } else {
            return $this->responseMessage(false, 'Login failed', null, 401);
        }

    }

    public function logout (Request $request) {
        $user=Auth::user();
        $user->tokens()->delete();
        return $this->responseMessage(true, 'User logout', null, 200);
    }

    public function profile(Request $request) {
        $user = Auth::user();
        return $this->responseMessage(true, 'User profile', ['user' => $user], 200);
    }
}
