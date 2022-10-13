<?php

namespace App\Enum;

enum StatusVenda : string
{
    case AGUARDANDO = 'AGUARDANDO';
    case PAGO = 'PAGO';
    case CANCELADO = 'CANCELADO';
}
