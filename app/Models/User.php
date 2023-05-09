<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> 
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'birth_date',
        'role',
        'status',
        'gender',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function worker(){
        return $this->hasOne(worker::class);
    }

    public function workerrates(){
        return $this->hasMany(Workerrate::class);
    }

    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    public function teacherrates(){
        return $this->hasMany(Teacherrate::class);
    }

    public function doctorclinic(){
        return $this->hasOne(Doctorclinic::class);
    }

    public function doctorclinicrates(){
        return $this->hasMany(Doctorclinicrate::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function shoprates(){
        return $this->hasMany(Shoprates::class);
    }
}
