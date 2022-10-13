<?php

namespace App\Repository;

use App\DomainModel\ProdutoVenda as ProdutosVendaEntity;
use App\Models\ProdutosVenda as ProdutosVendaModel;
use App\Repository\Contracts\IProdutosVendas;

class ProdutosVendas implements IProdutosVendas
{
    public function create(array $data): ProdutosVendaEntity
    {
        return new ProdutosVendaEntity(ProdutosVendaModel::create($data)->toArray());
    }
}
