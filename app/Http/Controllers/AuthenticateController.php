<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\church;
use JWTAuth;
use API;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request) {

        // Get credentials from the request
        $credentials = ['email'=>$request->input('email'),'password'=> $request->input('password')];
        //dd($credentials);

        try {
            // Attempt to verify the credentials and create a token for the user.
            if (! $token = JWTAuth::attempt($credentials)) {
                return API::response()->array(['error' => 'invalid_credentials'])->statusCode(401);
            }
        } catch (JWTException $e) {
            // Something went wrong - let the app know.
            return API::response()->array(['error' => 'could_not_create_token'])->statusCode(500);
        }

        // Return success.
        return compact('token');
    }

    public function validateToken(){
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    public function regForm(){
        $churches = church::lists('name', 'id');
        return compact('churches');
    }
    public function regCreate(Request $request){
        $all_requests = $request->all();
        return compact('all_requests');
    }
}
