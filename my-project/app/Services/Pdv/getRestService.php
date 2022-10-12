<?php

namespace App\Services\Pdv;

use App\Enum\HttpResponses;
use App\Models\Pdv;
use App\Services\Contract\AbstractRestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class getRestService extends AbstractRestService
{

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        if(is_null($id)){
            return $this->jsonResponse(Pdv::all()->toArray(), HttpResponses::OK);
        }
        $pdvModel = Pdv::find($id);
        if(is_null($pdvModel)){
            return $this->jsonResponse(null, HttpResponses::NOT_FOUND);
        }
        return $this->jsonResponse($pdvModel->toArray(), HttpResponses::OK);
    }
}
