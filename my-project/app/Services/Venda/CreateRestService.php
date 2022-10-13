<?php

namespace App\Services\Venda;

use App\DomainModel\ProdutoVenda;
use App\DomainModel\Venda;
use App\Enum\HttpResponses;
use App\Models\ProdutosVenda;
use App\Services\Contract\AbstractRestService;
use App\Services\Produto\Contract\IValidateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CreateRestService extends AbstractRestService
{
    public function __construct(
        private IValidateService $produto
    )
    {
    }

    public function dispatch(array $data, mixed $id = null): JsonResponse|JsonResource
    {
        $produtos = $this->produto->get($data['produtos']);
        $produtosVendasEntity = $produtos->map(function (ProdutoVenda $produtoVenda) {
            $produtoVenda->setValorTotal($produtoVenda->getValorUnitario() * $produtoVenda->getQuantidade());
            return $produtoVenda;
        });

        $venda = new Venda();
        $venda->setPdvId($data['pdv_id']);

        $venda->setValor($this->calculateValueTotal($produtos));
        $vendaFinal = new Venda(\App\Models\Venda::create($venda->toArray()));

        $produtosVendasEntity->map(function (ProdutoVenda $produtoVenda) use ($vendaFinal) {
            $produtoVenda->setVendaId($vendaFinal->getId());
            $retorno = ProdutosVenda::create($produtoVenda->toArray());
            return new ProdutoVenda($retorno->toArray());
        });

        return $this->jsonResponse($vendaFinal->toArray(), HttpResponses::CREATED);
    }

    private function getDebitValue(int $pdvId) : float
    {
        return 0.0;
    }

    private function canCreateSale(float $debit, Venda $venda) : bool
    {
        $limit = 100.0; //find in pdv database
        return ($debit + $venda->getValor()) >= $limit;
    }

    private function calculateValueTotal(Collection $collection): float
    {
        $responseArray = $collection->map(function (ProdutoVenda $produtoVenda) {
            return $produtoVenda->getValorTotal();
        })->toArray();

        return (float)array_sum($responseArray);
    }
}
