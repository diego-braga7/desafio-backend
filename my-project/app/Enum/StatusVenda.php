<?php

namespace App\Enum;

enum StatusVenda : string
{
    case AGUARDANDO = 'AGUARDANDO_PAGAMENTO';
    case PAGO = 'PAGO';
    case CANCELADO = 'CANCELADO';
}
