<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // Para llenados masivos
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];  


    // Castear para el formato de tiempo
    protected $casts = [
        'day_of_week' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];


    // Relación inversa con Doctor
    public function doctor(){
        return $this->belongsTo(Doctor::class); 
    }




}
