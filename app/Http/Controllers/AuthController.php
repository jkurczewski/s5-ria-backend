<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' =>$fields['name'],
            'email' =>$fields['email'],
            'password' =>bcrypt($fields['password'])
        ]);

        return response()->json(['Succesfully created new account. You can now log in.', $user], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'status_code' => 500,
                'message' => 'Unauthorized'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        $user->save();

        return response()->json([
            'status_code' => 200,
            'token' => $tokenResult
        ]);

    }

    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $bt = $request->bearerToken();

        if(!$bt) return response()->json([
            'status_code' => 400,
            'message' => 'We could not locate the proper info in order to logout this user'
        ]);

        $split_string = explode("|", $bt);
        $token_id = (int)$split_string[0];

        $personal_token_object = DB::table('personal_access_tokens')->where('id', $token_id)->first();


        if($user && $bt && $personal_token_object) {

            if(($personal_token_object->tokenable_id == $user->id) && ($personal_token_object->id == $token_id))
            {
                $personal_token_object = DB::table('personal_access_tokens')->delete($token_id);
            }
        }
        else
        {
            return response()->json([
                'status_code' => 400,
                'message' => 'We could not locate the proper info in order to logout this user'
            ]);
        }

        if($personal_token_object)
        {
            return response()->json([
                'status_code' => 200,
                'message' => 'Logged out successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status_code' => 400,
                'message' => 'We could not locate the proper info in order to logout this user'
            ]);
        }

    }
}
