<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{

    public function registration(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'required|min:5',
                'email' => 'required|email|unique:users',
            ]);

            if ($validator->fails()) {
                return Response(false, 400);
            }
            $data = $request->all();
            $check = $this->create($data);
            Auth::login($check);
            $token = $request->user()->createToken('token-name');
            return Response(['token' => $token->plainTextToken], 200);
        } catch (\Exception $e){
            return Response(false, 400);
        }
    }
//1|nV8kkSqBTkYe4VxjOxn3x7QnxgMjEVk7J8ap9glH
    private function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }


    public function login(Request $request){
        try{
            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)){
                Auth()->user()->tokens()->delete();
                $token = $request->user()->createToken('token-name');
                return Response (['token' => $token->plainTextToken], 200);
            } else {
                return Response( false, 400);
            }
        } catch (\Exception $e){
            return Response( false, 400);
        }
    }

    public function logout(Request $request){

    }
}
