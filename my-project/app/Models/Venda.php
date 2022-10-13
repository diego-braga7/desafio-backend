<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'venda';

    protected $fillable = [
        'id',
        'pdv_id',
        'valor',
        'status',
        'quitado',
    ];

    protected $casts = [
        'quitado' => 'boolean'
    ];

    public function pdv() : HasOne
    {
        return $this->hasOne(
          Pdv::class,
          'id',
          'pdv_id'
        );
    }

    public function produtosVendas() : hasMany
    {
        return $this->hasMany(ProdutosVenda::class, 'venda_id', 'id');
    }
}
