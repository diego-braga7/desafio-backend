<?php
namespace App\Validation\Services\Venda;

use App\Validation\Services\Venda\Contracts\ACreateValidationService;

class CreateValidationService extends ACreateValidationService
{

    protected function getRules(): array
    {
       return [
           'pdv_id' => [self::REQUIRED, 'exists:pdv,id'],
           'produtos' => [self::REQUIRED, 'array'],
       ];
    }
}
