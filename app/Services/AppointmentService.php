<?php

    namespace App\Services;

use App\Models\Appointment;
use App\Models\BussinesHour;
use Carbon\Carbon;

class AppointmentService{
    public function generateTimeData(Carbon $date){
        $dayName=$date->format('l');

            $bussnisHours=BussinesHour::where("day",$dayName)->first();
            $Hours= array_filter($bussnisHours->TimesPeriod);


            $curruntAppointments=Appointment::where('date',$date->toDateString())->pluck('time')->map(function($time){
                return $time->format('H:i');
            })->toArray();

            $availableAppoinments=array_diff($Hours,$curruntAppointments);

            return [
                'day_name'=>$dayName,
                'date'=>$date->format('d M'),
                'full_date'=>$date->format('Y-m-d'),
                'bussines_hours'=>$Hours,
                'reserved_hours'=>$curruntAppointments,
                'available_hours'=>$availableAppoinments,
                'off'=>$bussnisHours->off
            ];
    }
}