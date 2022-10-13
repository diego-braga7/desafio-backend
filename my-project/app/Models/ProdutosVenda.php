<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProdutosVenda extends Model
{
    use HasFactory;

    protected $table = 'produtos_venda';

    protected $fillable = [
        'id',
        'venda_id',
        'produto_id',
        'descricao',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    protected $casts = [

    ];

    public function venda() : HasOne
    {
        return $this->hasOne(
            Venda::class,
            'id',
            'venda_id'
        );
    }
}
