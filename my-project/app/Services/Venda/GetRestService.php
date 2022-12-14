<?php

namespace App\Services\Venda;

use App\Enum\HttpResponses;
use App\Models\Venda;
use App\Repository\Contracts\IVendas;
use App\Services\Contract\AbstractRestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class GetRestService extends AbstractRestService
{
    public function __construct( private IVendas $vendasRepository)
    {
    }

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        if(is_null($id)){
            return JsonResource::collection($this->getCollection($data)->toArray());
        }
        $venda = $this->vendasRepository->find($id);
        if(is_null($venda)){
            return $this->jsonResponse(null, HttpResponses::NOT_FOUND);
        }
        return $this->jsonResponse($venda->toArray());
    }

    private function getCollection(array $data)
    {
        return isset($data['status']) ? $this->vendasRepository->getByStatus($data['status']) :
            $this->vendasRepository->all();
    }
}
