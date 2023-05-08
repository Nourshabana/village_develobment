<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable=['school_id','user_id','name','photo','stage','subject','rate_count','rate'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function school(){
        return $this->belongsTo(School::class);
    }
    public function teacherrates(){
        return $this->hasMany(Teacherrate::class);
    }
}
