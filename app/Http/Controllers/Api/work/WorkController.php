<?php

namespace App\Http\Controllers\Api\work;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClinicRequest;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\WorkerResource;
use App\Models\Work;
use App\Models\worker as ModelsWorker;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Queue\Worker;

class WorkController extends Controller
{
    use HttpResponses;
    
    
    public function index(){
        return ClinicResource::collection(Work::all());
    }



    public function show(Work $work){
        return WorkerResource::collection(ModelsWorker::where('works_id',$work->id)->get());

    }



public function store(ClinicRequest $request){
    $user=auth()->user();
    if($user->hasRole('admin')){
        $request->validated($request->all());
    $filename=$this->uploadimage($request,'work');
    $work=Work::create([
        'name'=>$request->name,
        'photo'=>$filename
    ]);
    return new ClinicResource ($work);
    }
    

 }


 public function update(Request $request,$id){
    $user=auth()->user();
    if($user->hasRole('admin')){
    $work=Work::findOrFail($id);
    if($request-> has('name')){
        $work->name=$request->name;
    }
    $filename=$this->updateimage($request,'work',$work);
    
    $work->photo=$filename;
    $work->save();
    return new ClinicResource($work);
    }
}


public function destroy($id){
    $user=auth()->user();
    if($user->hasRole('admin')){
    $work=Work::findOrFail($id);
    $this->deleteimage($work);
    $result=$work->delete();
    return $this->succes('','your record was deleted succesfully');
    }
}
}

