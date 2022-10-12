<?php

namespace App\Services\Pdv;

use App\Enum\HttpResponses;
use App\Models\Pdv;
use App\Services\Contract\AbstractRestService;
use App\Services\Pdv\Contracts\IUpdateRestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateRestService extends AbstractRestService
{
    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        $pdvModel =  Pdv::find($id);
        if(is_null($pdvModel)){
            return $this->jsonResponse(null, HttpResponses::NOT_FOUND);
        }
        return $this->jsonResponse($pdvModel->fill($data)->save(), HttpResponses::OK);
    }
}
