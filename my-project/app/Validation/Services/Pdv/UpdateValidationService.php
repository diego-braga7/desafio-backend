<?php

namespace App\Validation\Services\Pdv;

use App\Validation\Services\Pdv\Contracts\AUpdateValidationService;

class UpdateValidationService extends AUpdateValidationService
{
    protected function getRules(): array
    {
        return [
            'nome_fantasia' => [self::SOMETIMES, 'string'],
            'nome_responsavel' => [self::SOMETIMES, 'between:3,100'],
            'celular_responsavel' => [self::SOMETIMES, 'between:4,25'],
            'limite_venda_pos' => [self::SOMETIMES, 'numeric'],
        ];
    }
}
