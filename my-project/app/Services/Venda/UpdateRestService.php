<?php

namespace App\Services\Venda;

use App\Enum\HttpResponses;
use App\Enum\StatusVenda;
use App\Models\Venda;
use App\Repository\Contracts\IVendas;
use App\Services\Contract\AbstractRestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateRestService  extends AbstractRestService
{
    public function __construct( private IVendas $vendasRepository)
    {
    }

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        $venda = $this->vendasRepository->find($id);

        if(is_null($venda)){
            return $this->jsonResponse(null, HttpResponses::NOT_FOUND);
        }
        if($venda->getStatus() == StatusVenda::PAGO->value){
            return $this->jsonResponse("Compra já paga", HttpResponses::UNPROCESSABLE_ENTITY);
        }
        $this->vendasRepository->changeStatus($id, $data['status']);

        return $this->jsonResponse(null);

    }
}
