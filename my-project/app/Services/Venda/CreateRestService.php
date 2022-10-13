<?php

namespace App\Services\Venda;

use App\DomainModel\ProdutoVenda;
use App\DomainModel\Venda;
use App\Enum\HttpResponses;
use App\Enum\StatusVenda;
use App\Models\Pdv;
use App\Models\ProdutosVenda;
use App\Repository\Contracts\IPdv;
use App\Repository\Contracts\IProdutosVendas;
use App\Repository\Contracts\IVendas;
use App\Services\Contract\AbstractRestService;
use App\Services\Produto\Contract\IValidateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CreateRestService extends AbstractRestService
{
    public function __construct(
        private IValidateService $produto,
        private IVendas          $vendasRepository,
        private IProdutosVendas  $produtosVendasRepository,
        private IPdv             $pdvRepository
    )
    {
    }

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        $produtos = $this->produto->get($data['produtos']);

        if(count($data['produtos']) != $produtos->count()){
            return $this->jsonResponse("Produto não encontrado.", HttpResponses::UNPROCESSABLE_ENTITY);
        }
        $produtosVendasEntity = $produtos->map(function (ProdutoVenda $produtoVenda) {
            $produtoVenda->setValorTotal($produtoVenda->getValorUnitario() * $produtoVenda->getQuantidade());
            return $produtoVenda;
        });

        $venda = new Venda();
        $venda->setPdvId($data['pdv_id']);

        $venda->setValor($this->calculateValueTotal($produtos));

        $debit = $this->vendasRepository->getDebitValue($venda->getPdvId());

       if(!$this->canCreateSale($debit, $venda)){
           return $this->jsonResponse("Limite estourado.", HttpResponses::UNPROCESSABLE_ENTITY);
       }

        $vendaFinal = $this->vendasRepository->create($venda->toArray());


        $produtosVendasEntity->map(function (ProdutoVenda $produtoVenda) use ($vendaFinal) {
            $produtoVenda->setVendaId($vendaFinal->getId());
            return $this->produtosVendasRepository->create($produtoVenda->toArray());
        });

        return $this->jsonResponse($vendaFinal->toArray(), HttpResponses::CREATED);
    }


    private function canCreateSale(float $debit, Venda $venda) : bool
    {
        $limit = $this->pdvRepository->getLimit($venda->getPdvId());
        return ($debit + $venda->getValor()) < $limit;
    }

    private function calculateValueTotal(Collection $collection): float
    {
        $responseArray = $collection->map(function (ProdutoVenda $produtoVenda) {
            return $produtoVenda->getValorTotal();
        })->toArray();

        return (float)array_sum($responseArray);
    }
}
