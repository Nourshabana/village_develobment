<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    private $otp;
    public function __construct(){
        $this->otp=new Otp;
    }

    public function resetPassword(ResetPasswordRequest $request){
        $otp2=$this->otp->validate($request->email,$request->otp);
        if(!$otp2->status){
            return response()->json(['error'=>$otp2],401);
        }
        $user =User::where('email',$request->email)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens->each->delete();
        return response()->json(['success'=>true],200);
    }
}
