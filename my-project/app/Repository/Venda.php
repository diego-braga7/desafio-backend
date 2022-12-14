<?php

namespace App\Repository;

use App\DomainModel\Venda as VendaEntity;
use App\Enum\StatusVenda;
use App\Models\Venda as VendaEloquent;
use App\Repository\Contracts\IVendas;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionSupport;
use Illuminate\Support\Facades\DB;

class Venda implements IVendas
{

    public function getDebitValue(int $pdvId): float
    {
        $debit = DB::select("
            SELECT SUM(valor) AS debit FROM venda WHERE pdv_id = :pdvId AND `status` = :status
        ", [
            'pdvId' => $pdvId,
            'status' => StatusVenda::AGUARDANDO->value,
        ]);
        return (float)current($debit)->debit;
    }

    public function create(array $data): VendaEntity
    {
        return new VendaEntity(VendaEloquent::create($data)->toArray());
    }

    public function changeStatus(int $id, string $status) : bool
    {
        return $this->update($id, [
            'status' => $status
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $venda = VendaEloquent::find($id);

        return $venda->fill($data)->save();
    }

    public function find(int $id): ?VendaEntity
    {
        $venda = VendaEloquent::find($id);
        if(!$venda){
            return null;
        }

        return new VendaEntity($venda->toArray());
    }

    public function getByStatus(string $status) : CollectionSupport
    {
       $vendas = VendaEloquent::where('status', $status)
            ->get();
      return $this->mapToDomainModel($vendas);
    }

    private function mapToDomainModel($vendas) : CollectionSupport
    {
        return $vendas->map(function($venda){
            return new VendaEntity($venda->toArray());
        });
    }

    public function all() : CollectionSupport
    {
        /**
         * @var $vendas Collection
         */
        return VendaEloquent::all();

       return $vendas->map(function($venda){
            return new VendaEntity($venda->toArray());
        });
    }
}
