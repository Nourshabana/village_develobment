<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorClinicRequest;
use App\Http\Resources\DoctorClinicResource;
use App\Models\BussinesHour;
use App\Models\Doctorclinic;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorclinicController extends Controller
{
    use HttpResponses;
    public function store(StoreDoctorClinicRequest $request){
        $request->validated($request->all());
        $doctoruser=new User();
        $doctor=new Doctorclinic();
        $filename=$this->uploadimage($request,'Doctorclinics');
        $doctoruser->email=$request->email;
        $doctoruser->first_name=$request->first_name;
        $doctoruser->last_name=$request->last_name;
        $doctoruser->password=Hash::make($request->password);
        if($request->has('phone')){$doctoruser->phone=$request->phone;}
        $doctoruser->assignRole('Doctor');
        $doctoruser->save();
        $doctor->user_id=$doctoruser->id;
        $doctor->name=$request->first_name.' '.$request->last_name;
        $doctor->price=$request->price;
        $doctor->field=$request->field;
        if ($filename){$doctor->photo=$filename;}
        $doctor->save();
        $days=config('appointment.days');
        foreach($days as $day){
            $doctorHours=new BussinesHour();
                $doctorHours->doctorclinic_id=$doctor->id;
                $doctorHours->day=$day;
                $doctorHours->from='09:00';
                $doctorHours->to='17:00';
                $doctorHours->step=30;
                $doctorHours->save();
        }
        return new DoctorClinicResource($doctor);
        
    }
}
