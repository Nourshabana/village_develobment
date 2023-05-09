<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable=['name','photo','location','rate','rate_count'];

    public function shoprates(){
        return $this->hasMany(Shoprates::class);
    }
}
