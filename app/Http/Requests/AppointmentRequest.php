<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\BussinesHour;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(){
        $this->isValid();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'date'=>['required','date_format:Y-m-d'],
            'time'=>['required','date_format:H:i'],


        ];
    }

    private function isValid(){

        $count = 5;
        $dates = [];
        $date = Carbon::now()->format('Y-m-d');
        $date1 = Carbon::now();
        array_push($dates, $date);
        for ($i = 0; $i <= $count; $i++) {
            $dates[] = $date1->addDay()->format('Y-m-d');
}$d=$this->date('date')->format('l');
$holidayes=BussinesHour::where('off',1)->pluck('day')->toArray();
if(!in_array($this->input('date'),$dates)|| in_array($d,$holidayes)){abort(422,'متشغلش دماغ امك علينا');}



        $dayName=$this->date('date')->format('l');

        $businisHours=BussinesHour::where('day',$dayName)->first()->TimesPeriod;
        if(!in_array($this->input('time'),$businisHours)){
            abort(422,'invalid time');
        }
        $checkappoint=Appointment::where('date',$this->input('date'))->where('time',$this->input('time'))->exists();
        if($checkappoint){
            abort(422,'appointment is already taken');
        }
        
    }
}
