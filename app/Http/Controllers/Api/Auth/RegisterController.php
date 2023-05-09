<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $newuser=$request->validated();
        $newuser['password']=Hash::make($newuser['password']);
        $newuser['role']='user';
        
        
        $user=User::create($newuser);

        $success['Token']=$user->createToken('user',['app:all'])->plainTextToken;
        $success['name']=$user->name;
        $success['success']=True;
        // try{
        //     $user->notify(new EmailVerificationNotification());
        // }catch(\Exception $e){}
        

        return response()->json($success,200);
    }
}
