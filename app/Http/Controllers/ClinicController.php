<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ClinicRequest;
use App\Http\Resources\ClinicResource;
use App\Models\Clinic;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;


class ClinicController extends Controller
{
    use HttpResponses;
    
    public function index(){
        return ClinicResource::collection(Clinic::all());
    }



    public function show($id){
        return ClinicResource::collection(Clinic::where('id',$id)->get());

    }



public function store(ClinicRequest $request){
    $user=auth()->user();
    if($user->hasRole('admin')){
        $request->validated($request->all());
    $filename=$this->uploadimage($request,'clinics');
    $clinic=Clinic::create([
        'name'=>$request->name,
        'photo'=>$filename
    ]);
    return new ClinicResource ($clinic);
    }
    

 }


 public function update(Request $request,$id){
    $user=auth()->user();
    if($user->hasRole('admin')){
    $clinic=Clinic::findOrFail($id);
    if($request-> has('name')){
        $clinic->name=$request->name;
    }
    $filename=$this->updateimage($request,'clinics',$clinic);
    
    $clinic->photo=$filename;
    $clinic->save();
    return new ClinicResource($clinic);
    }
}


public function destroy($id){
    $user=auth()->user();
    if($user->hasRole('admin')){
    $clinic=Clinic::findOrFail($id);
    $this->deleteimage($clinic);
    $result=$clinic->delete();
    return $this->succes('','your record was deleted succesfully');
    }
}
}
