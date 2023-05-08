<?php

namespace App\Models;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinesHour extends Model
{
    use HasFactory;

    protected $guarded=[ 'doctorclinic_id','day','from','to','step','off'];

    public function doctorclinic(){
        return $this->belongsTo(Doctorclinic::class);
    }

    public function getTimesPeriodAttribute(){
        /////بيقسم المواعيد بتاعت اليوم الواحد/////////////
        $times= CarbonInterval::minute($this->step)->toPeriod($this->from,$this->to)->toArray();

        return array_map(function($time){ 
            //////////////بشوف لو المعاد كان نفس اليوم وعدى يبقا ميظهروش///////////
            if($this->day==today()->format('l') && !$time->isPast()){
                return $time->format('H:i');
            }if($this->day!=today()->format('l')){
                return $time->format('H:i');
            }
        },$times);
    }
}


