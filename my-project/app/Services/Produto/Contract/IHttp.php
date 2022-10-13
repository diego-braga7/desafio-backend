<?php
namespace App\Services\Produto\Contract;

use Illuminate\Database\Eloquent\Collection;

interface IHttp
{
    public function request() : Collection;
}
