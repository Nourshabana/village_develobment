<?php

    namespace App\Traits;

use App\Http\Requests\StoreProfessionSectionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


    trait HttpResponses{
        protected function succes($data,$message=null,$code=200){

            return response()->json([
                'status'=>'Request was succesfull',
                'message'=>$message,
                'data'=>$data
            ],$code);
        }



        protected function error($data,$message=null,$code){

            return response()->json([
                'status'=>'Error has occurd..',
                'message'=>$message,
                'data'=>$data
            ],$code);
        }

        protected function uploadimage(Request $request,$foldername){
            $str_rand=Str::random(8);
            $image_path=$str_rand.time().".png";
            if($request->hasFile('photo')){
            $filename=$request->file('photo')->storeAs($foldername,$image_path,'nour');}else{$filename=false;}
            
            return $filename;
        }


        protected function updateimage(Request $request,$foldername ,$record ){
            $destination=public_path("imgs\\".$record->photo);
            $filename="";
            if($request->hasFile('photo')){
                #بيشوف المسار بتاعها موجود ولا لأ لو موجود هيمسحها 
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $str_rand=Str::random(8);
                $image_path=$str_rand.time().".png";
                #بيرفع الصورة الجديدة
                $filename=$request->file('photo')->storeAs($foldername,$image_path,'nour');
            }else{
                #لو اللي بيحدث مش عايز يحدثها اصلا هيجيبله القديمة
                $filename=$record->photo;
            }

            return $filename;
        }

        protected function deleteimage($record ){
            $message=true;
            $destination=public_path("imgs\\".$record->photo);
            if(File::exists($destination)){
                File::delete($destination);
            }
                return $message;
        }


    }