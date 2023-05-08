<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Models\User;
use App\Notifications\Api\Auth\ResetPasswordVerificationNotification;

class ForgetPasswordController extends Controller
{
    public function forgetPassword(ForgetPasswordRequest $request){
        $input=$request->only('email');
        $user=User::where('email',$input)->first();
        $user->notify(new ResetPasswordVerificationNotification());
        return response()->json(['success'=>true,'message'=>'we send your code at '.$user->email],200);
    }
}
