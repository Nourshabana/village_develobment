<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRateStoreRequest;
use App\Models\Teacher;
use App\Models\Teacherrate;
use Illuminate\Http\Request;

class TeacherrateController extends Controller
{
    public function update(WorkerRateStoreRequest $request,Teacher $teacher){
        $request->validated($request->all());
        $record=Teacherrate::where('user_id', auth()->user()->id)->where('teacher_id',$teacher->id)->first();
        if($record){
            $record->rate =$request->rate;
            $record->save();
            $totalofrates=Teacherrate::where('teacher_id',$teacher->id)->sum('rate');
            $teacher->rate=$totalofrates/$teacher->rate_count;
            $teacher->save();
            return response()->json(['message'=>'your rate has been updated successfully','total'=>$totalofrates],200);
        }else{
            $worker_rate=new Teacherrate();
        $worker_rate->user_id=auth()->user()->id;
        $worker_rate->teacher_id=$teacher->id;
        $worker_rate->rate =$request->rate;
        $worker_rate->save();
        // $countofrates=Workerrate::where('id',$worker->id)->count();
        $teacher->rate_count++;
        $totalofrates=Teacherrate::where('teacher_id',$teacher->id)->sum('rate');
        $teacher->rate=$totalofrates/$teacher->rate_count;
        $teacher->save();
        return response()->json(['message'=>'your rate has been saved','total'=>$totalofrates],200);
        }


    }
}
