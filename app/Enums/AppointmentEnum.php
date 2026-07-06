<?php

namespace App\Enums;

enum AppointmentEnum: int
{
    //
    case SCHEDULED = 1;
    case COMPLETED = 2;
    case CANCELED = 3;
    case EN_PROCESO = 4;
    case CERRADA_X_SISTEMA = 5;

    public function label(): string
    {
        return match($this) {
            self::SCHEDULED => 'Agendada',
            self::COMPLETED => 'Terminada',
            self::CANCELED => 'Cancelada',
            self::EN_PROCESO => 'En Proceso',
            self::CERRADA_X_SISTEMA => 'Cerrada por Sistema'
        };
    }


}
