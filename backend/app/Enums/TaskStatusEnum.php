<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case Pendiente = 'pendiente';
    case Iniciado = 'en_progreso';
    case Completada = 'completada';
}
