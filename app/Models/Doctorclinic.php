<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctorclinic extends Model
{
    use HasFactory;

    protected $fillable=['user_id', 'name', 'photo','price','field','rate','rate_count'];



    public function user(){
        return $this->belongsTo(User::class);
    }
    public function doctorclinicrates(){
        return $this->hasMany(Doctorclinicrate::class);
    }

    public function bussines_hours(){
        return $this->hasMany(BussinesHour::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
