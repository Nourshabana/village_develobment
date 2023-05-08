<?php

namespace App\Http\Controllers\Api\work;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorkerRequest;
use App\Http\Resources\WorkerResource;
use App\Models\User;
use App\Models\Work;
use App\Models\worker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware(['role:admin',]);
    }


    public function store(StoreWorkerRequest $request){
        $request->validated($request->all());
        $workeruser=new User();
        $worker=new worker();
        $filename=$this->uploadimage($request,'workers');
        $workers=Work::where('name','like','%'.$request->jobname.'%')->first();
        $workeruser->first_name=$request->first_name;
        $workeruser->last_name=$request->last_name;
        $workeruser->email=$request->email;
        $workeruser->phone=$request->phone;
        // $workeruser->status='active';
        $workeruser->password=Hash::make($request->password);
        $workeruser->assignRole('worker');
        $workeruser->save();
        $worker->user_id=$workeruser->id;
        $worker->name=$request->first_name.' '.$request->last_name;        
        $worker->jobname=$request->jobname;
        $worker->works_id=$workers->id;
        $worker->address=$request->address;
        $worker->worktime=$request->worktime;
        if ($filename){$worker->photo=$filename;}
        $worker->save();
        return new WorkerResource($worker);

    }

    public function index()
    {
        
        return WorkerResource::collection(worker::all());
        //
    }
    public function show(Worker $worker)
    {
        return WorkerResource::collection(Worker::where('id',$worker->id)->get());
        //
    }

    public function update(Request $request,Worker $worker )
    {
        $user=User::where('id',$worker->user_id)->first();
        $validator = Validator::make($request->all(), [
            'phone' => [
                'sometimes',
                Rule::unique('users')->ignore($user->id),
            ],
            'address'=>['sometimes','string'],
            'worktime'=>['sometimes','string'],
            'photo'=>['sometimes','max:2000','mimes:png,jpg']
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        if ($request->has('address')){$worker->address=$request->address;}else{$worker->address=$worker->address;}
        if ($request->has('worktime')){$worker->worktime=$request->worktime;}else{$worker->worktime=$worker->worktime;}
        if ($request->has('phone')){$user->phone=$request->phone;}else{$user->phone=$user->phone;}
        $filename=$this->updateimage($request,'workers',$worker);
        $user->save();
        $worker->photo=$filename;
        $worker->save();
        return new WorkerResource($worker);
    }
    public function destroy( Worker $worker)
    {
        $user=User::where('id',$worker->user_id)->first();
        $user->removeRole('worker');
        if($worker->photo!='user.png'){
        if($this->deleteimage($worker)){$worker->delete();}}else{$worker->delete();}
        $user->delete();
        return $this->succes('','your record was deleted succesfully');
        //
    }

}
