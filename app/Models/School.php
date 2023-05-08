<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable=['name','photo'];

    public function teachers(){
        return $this->hasMany(Teacher::class);
    }
}
