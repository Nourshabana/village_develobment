<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRateStoreRequest;
use App\Models\Shop;
use App\Models\Shoprates;
use Illuminate\Http\Request;

class ShopratesController extends Controller
{
    public function update(WorkerRateStoreRequest $request,Shop $shop){
        $request->validated($request->all());
        $record=Shoprates::where('user_id', auth()->user()->id)->where('shop_id',$shop->id)->first();
        if($record){
            $record->rate =$request->rate;
            $record->save();
            $totalofrates=Shoprates::where('shop_id',$shop->id)->sum('rate');
            $shop->rate=$totalofrates/$shop->rate_count;
            $shop->save();
            return response()->json(['message'=>'your rate has been updated successfully','total'=>$totalofrates],200);
        }else{
            $worker_rate=new Shoprates();
        $worker_rate->user_id=auth()->user()->id;
        $worker_rate->shop_id=$shop->id;
        $worker_rate->rate =$request->rate;
        $worker_rate->save();
        // $countofrates=Workerrate::where('id',$worker->id)->count();
        $shop->rate_count++;
        $totalofrates=Shoprates::where('shop_id',$shop->id)->sum('rate');
        $shop->rate=$totalofrates/$shop->rate_count;
        $shop->save();
        return response()->json(['message'=>'your rate has been saved','total'=>$totalofrates],200);
        }


    }
}
