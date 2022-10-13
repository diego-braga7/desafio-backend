<?php

namespace App\Repository\Contracts;

use App\DomainModel\Venda as VendaEntity;
use Illuminate\Support\Collection as CollectionSupport;

interface IVendas
{
    public function getDebitValue(int $pdvId): float;

    public function create(array $data): VendaEntity;

    public function changeStatus(int $id, string $status) : bool;

    public function update(int $id, array $data): bool;

    public function find(int $id): ?VendaEntity;

    public function all() : CollectionSupport;
}
