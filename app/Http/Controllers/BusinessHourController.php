<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusnissHourRequest;
use App\Models\BussinesHour;
use Illuminate\Http\Request;

class BusinessHourController extends Controller
{
    //

    public function index(){
        
        $busnisshours=BussinesHour::all();
        return view('appointments.business_hours',compact('busnisshours'));
    }

    public function update(BusnissHourRequest $request){
        
        BussinesHour::query()->upsert($request->validated()['data'],['day']);
        return back();
        
    }
}
