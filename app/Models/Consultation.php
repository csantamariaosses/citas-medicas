<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'appointment_id',
        'diagnostic',
        'treatment',
        'notes',
        'prescriptions'
    ];

    protected $casts = [
        'prescriptions' => 'json',
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }   
}
