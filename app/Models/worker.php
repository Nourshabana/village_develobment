<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class worker extends Model
{
    use HasFactory;
    protected $fillable=[
        'works_id','user_id','name','jobname','address','worktime','photo','rate_count','rate'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function work(){
        return $this->belongsTo(Work::class);
    }
    public function workerrates(){
        return $this->hasMany(Workerrate::class);
    }
}
