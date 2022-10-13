<?php

namespace App\Services\Venda;

use App\DomainModel\ProdutoVenda;
use App\DomainModel\Venda;
use App\Enum\HttpResponses;
use App\Enum\StatusVenda;
use App\Models\Pdv;
use App\Models\ProdutosVenda;
use App\Services\Contract\AbstractRestService;
use App\Services\Produto\Contract\IValidateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        $debit = $this->getDebitValue($venda->getPdvId());

       if(!$this->canCreateSale($debit, $venda)){
           return $this->jsonResponse("Limite estourado.", HttpResponses::UNPROCESSABLE_ENTITY);
       }

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
       $debit = DB::select("
            SELECT SUM(valor) AS debit FROM venda WHERE pdv_id = :pdvId AND `status` != :status AND quitado = :quitado
        ", [
            'pdvId' => $pdvId,
            'status' => StatusVenda::CANCELADO->value,
            'quitado' => 0,
        ]);
       return (float) current($debit)->debit;
    }

    private function canCreateSale(float $debit, Venda $venda) : bool
    {
        $limit = Pdv::find($venda->getPdvId())->limite_venda_pos;
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
