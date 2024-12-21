<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

abstract class Controller
{
    public function checkUserAuth($email) {
        $user =User::where('email', $email)->first();
        $user_id = $user->id;
        $token = PersonalAccessToken::where('tokenable_id', $user_id)->first();
        if ($token) return true;
        else return false;
    }

    public function responseMessage($status, $message, $data = null, $httpCode)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $httpCode);
    }
}
