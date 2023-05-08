<?php

namespace App\Http\Controllers\Api\school;
use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Resources\ClinicResource;
use App\Http\Requests\Api\ClinicRequest;
use App\Traits\HttpResponses;

class SchoolController extends Controller
{use HttpResponses;
    
    public function index(){
        return ClinicResource::collection(School::all());
    }



    public function show($id){
        return ClinicResource::collection(School::where('id',$id)->get());

    }



public function store(ClinicRequest $request){
    $user=auth()->user();
    // if($user->hasRole('admin')){
        $request->validated($request->all());
    $filename=$this->uploadimage($request,'Schools');
    $work=School::create([
        'name'=>$request->name,
        'photo'=>$filename
    ]);
    return new ClinicResource ($work);
    //}
    

 }


 public function update(Request $request,$id){
    $user=auth()->user();
    // if($user->hasRole('admin')){
    $work=School::findOrFail($id);
    if($request-> has('name')){
        $work->name=$request->name;
    }
    $filename=$this->updateimage($request,'Schools',$work);
    
    $work->photo=$filename;
    $work->save();
    return new ClinicResource($work);
    // }
}


public function destroy($id){
    $user=auth()->user();
    // if($user->hasRole('admin')){
    $work=School::findOrFail($id);
    $this->deleteimage($work);
    $result=$work->delete();
    return $this->succes('','your record was deleted succesfully');
    // }
}
}
