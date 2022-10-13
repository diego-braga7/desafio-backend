<?php

namespace App\Services\Venda;

use App\DomainModel\ProdutoVenda;
use App\Services\Contract\AbstractRestService;
use App\Services\Produto\Contract\IValidateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CreateRestService  extends AbstractRestService
{
    public function __construct(
        private IValidateService $produto
    )
    {
    }

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        $produtos = $this->produto->get($data['produtos']);
        $this->calculateValueTotal($produtos);
        dd($produtos);
        // TODO: Implement dispatch() method.
    }

    private function calculateValueTotal(Collection $collection)
    {
        $collection->map(function (ProdutoVenda $produtoVenda){
            $produtoVenda->setValorTotal($produtoVenda->getValorUnitario()*$produtoVenda->getQuantidade());
        });
    }
}
