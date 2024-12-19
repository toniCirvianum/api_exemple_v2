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

        $this->checkUserAuth();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
                'errorCode' => 422
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        $token = $user->createToken()->plainTextToken;
        return response()->json([
            'status'=>true,
            'user'=> $user,
            'message'=>"new user registered",
            'token'=>$token,
            'httpCode'=>200
        ]);


    }

    public function login(Request $request){
        $this->checkUserAuth();
        //Valdiacio de dades
        //comprovacio del login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user -> createToken('Api-Token')->plainTextToken;
            return response()->json([
                'status'=>true,
                'token'=>$token,
                'message'=> 'Login succesfull',
                'httpCode'=>200
            ]);
        } else {
            return response()->json([
                'status'=>false,
                'message'=> 'Login succesfull',
                'httpCode'=>401
            ]);
        }

    }

    public function logout (Request $request) {
        $user=Auth::user();
        $user->tokens->delete();
        return response()->json([
            'status'=>true,
            'messagge'=>'USer logout',
            'httpCode'=>200
        ]);

    }
}
