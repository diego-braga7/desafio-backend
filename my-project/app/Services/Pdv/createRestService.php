<?php

namespace App\Services\Pdv;

use App\Enum\HttpResponses;
use App\Models\Pdv;
use App\Services\Contract\AbstractRestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class createRestService extends AbstractRestService
{
    public function __construct()
    {
    }

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
       $pdvModel =  Pdv::create($data);
       return $this->jsonResponse($pdvModel->toArray(), HttpResponses::CREATED);
    }
}
