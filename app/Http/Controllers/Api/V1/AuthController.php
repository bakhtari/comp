<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Models\User;


class AuthController extends Controller
{
    public function getToken(AuthRequest $request)
    {

        $user=User::where("email",$request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken($request->email);
        User::whereId($user->id)->update(["token"=>$token->plainTextToken]);
        return ['token' => $token->plainTextToken];
    }

}
