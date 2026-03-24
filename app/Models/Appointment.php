<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Appointment extends Model
{
    //
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'reason',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
        //'status' => AppointmentEnum::class,
    ];  

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }   

    public function patient(){
        return $this->belongsTo(Patient::class);
    }   

    public function consultation(){
        return $this->hasOne(Consultation::class);
    }   

    // Accesores
    public function start():Attribute {
        return Attribute::make (

            get: function() {
                $date = $this->date->format('Y-m-d');
                $time = $this->start_time->format('H:i:s');

                // Retornar en formato ISO 8601
                return Carbon::parse( "{$date} {$time}" )->toIso8601String();
            }
            
        );
    }

     public function end():Attribute {
        return Attribute::make (
            get: function() {
                $date = $this->date->format('Y-m-d');
                $time = $this->end_time->format('H:i:s');

                // Retornar en formato ISO 8601
                return Carbon::parse( "{$date} {$time}" )->toIso8601String();
            }
        );
    }
}
