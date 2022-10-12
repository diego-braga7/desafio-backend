<?php

namespace App\Services\Venda;

use App\Services\Contract\AbstractRestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateRestService  extends AbstractRestService
{

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        // TODO: Implement dispatch() method.
    }
}
