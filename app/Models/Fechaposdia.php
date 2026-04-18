<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fechaposdia extends Model
{
     protected $fillable = [
        'fecha',
        'day_of_week'
    ];
}
