<?php

namespace App\Repository;

use App\Models\Pdv as PdvEloquent;
use App\Repository\Contracts\IPdv;

class Pdv implements IPdv
{
 public function getLimit(int $id) : float
 {
    return PdvEloquent::find($id)->limite_venda_pos;
 }
}
