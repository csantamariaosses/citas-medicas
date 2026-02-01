<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    protected $fillable = [
        'user_id',
        'blood_type',
        'allergies',
        'chronic_conditions',
        'surgical_history',
        'medical_record_number',
        'date_of_birth',
        'address',
        'observations',
        'emergency_contact_name',
        'emergency_contact_phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
        //return $this->belongsTo(BloodType::class, 'blood_type_id', 'id');
    }
}
