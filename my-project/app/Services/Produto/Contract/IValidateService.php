<?php

namespace App\Services\Produto\Contract;
use Illuminate\Support\Collection;
interface IValidateService
{
    public function get(array $productsRequest) : Collection;
}
