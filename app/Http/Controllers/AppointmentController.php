<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\BussinesHour;
use App\Services\AppointmentService;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //

    public function index(){
        $datePeriod=CarbonPeriod::create(  now(),now()->addDay(6) );
        
        $appointments=[];
        foreach($datePeriod as $date){
            
            $appointments[]=(new AppointmentService)->generateTimeData($date);
            
        }

        return view('appointments.reserve',compact('appointments'));
    }


    public function reserve(AppointmentRequest $request){

        $data=$request->merge(['user_id'=>auth()->id()])->toArray();
        Appointment::create($data);
        return back();
    }
}
