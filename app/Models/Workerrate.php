<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workerrate extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'worker_id',
        'rate'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function worker(){
        return $this->belongsTo(worker::class);
    }
}
