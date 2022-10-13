<?php

namespace App\Repository\Contracts;

use App\DomainModel\ProdutoVenda as ProdutosVendaEntity;

interface IProdutosVendas
{
    public function create(array $data): ProdutosVendaEntity;
}
