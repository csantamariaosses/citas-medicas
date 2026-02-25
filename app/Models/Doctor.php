<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    //
    protected $fillable = [
        'user_id',
        'specialty_id',
        'medical_license_number',
        'biography',
    ];

    // Relaciones inversas
    public function user(){
        return $this->belongsTo(User::class);   
    }

    public function speciality(){
        return $this->belongsTo(Speciality::class);   
    }

    public function role(){
        return $this->user()->role()->pluck('name')->first();
    }


    // Relación uno a muchgos con Schedule
    public function schedules(){
        return $this->hasMany(Schedule::class); 
    }
    
}
