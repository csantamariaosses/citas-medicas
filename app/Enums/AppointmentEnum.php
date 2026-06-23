<?php

namespace App\Enums;

enum AppointmentEnum: int
{
    //
    case SCHEDULED = 1;
    case COMPLETED = 2;
    case CANCELED = 3;
    case EN_PROCESO = 4;

    public function label(): string
    {
        return match($this) {
            self::SCHEDULED => 'Agendada',
            self::COMPLETED => 'Terminada',
            self::CANCELED => 'Cancelada',
            self::EN_PROCESO => 'En Proceso'
        };
    }


}
