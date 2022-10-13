<?php

namespace App\Validation\Services\Venda;

use App\Enum\StatusVenda;
use App\Validation\Services\Venda\Contracts\AUpdateValidationService;
use Illuminate\Validation\Rules\Enum;

class UpdateValidationService extends AUpdateValidationService
{
    protected function getRules(): array
    {
        return [
            'status' =>  [ self::REQUIRED,new Enum(StatusVenda::class)],
        ];
    }
}
