<?php
namespace App\Validation\Services\Pdv;

use App\Validation\Services\Pdv\Contracts\ACreateValidationService;

class CreateValidationService extends ACreateValidationService
{

    protected function getRules(): array
    {
       return [
           'nome_fantasia' => [self::REQUIRED, 'string'],
           'cnpj' => [self::REQUIRED, 'unique:pdv','size:14'],
           'nome_responsavel' => [self::REQUIRED, 'between:3,100'],
           'celular_responsavel' => [self::REQUIRED, 'between:4,25'],
           'limite_venda_pos' => [self::SOMETIMES, 'numeric'],
       ];
    }
}
