<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $cred=[
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if(auth()->attempt($cred)){
            $user=User::where('email',$request->email)->first();
            $user->tokens->each->delete();
            $success['Token']=$user->createToken(request()->userAgent())->plainTextToken;   
            $success['name']=$user->first_name;
            $success['success']=true;
            // try{$user->notify(new LoginNotification());}catch(\Exception $e){}
            
            return response()->json($success);
        }
        return response()->json(['error'=>'unauthorized']);
    }
}
