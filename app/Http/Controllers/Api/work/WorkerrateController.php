<?php

namespace App\Http\Controllers\Api\work;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkerRateStoreRequest;
use App\Models\worker;
use App\Models\Workerrate;
use Illuminate\Http\Request;

class WorkerrateController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|worker',]);
    }
    public function update(WorkerRateStoreRequest $request,worker $worker,){
        $request->validated($request->all());
        $record=Workerrate::where('user_id', auth()->user()->id)->where('worker_id',$worker->id)->first();
        if($record){
            $record->rate =$request->rate;
            $record->save();
            $totalofrates=Workerrate::where('worker_id',$worker->id)->sum('rate');
            $worker->rate=$totalofrates/$worker->rate_count;
            $worker->save();
            return response()->json(['message'=>'your rate has been updated successfully','total'=>$totalofrates],200);
        }else{
            $worker_rate=new Workerrate();
        $worker_rate->user_id=auth()->user()->id;
        $worker_rate->worker_id=$worker->id;
        $worker_rate->rate =$request->rate;
        $worker_rate->save();
        // $countofrates=Workerrate::where('id',$worker->id)->count();
        $worker->rate_count++;
        $totalofrates=Workerrate::where('worker_id',$worker->id)->sum('rate');
        $worker->rate=$totalofrates/$worker->rate_count;
        $worker->save();
        return response()->json(['message'=>'your rate has been saved','total'=>$totalofrates],200);
        }


    }
}
