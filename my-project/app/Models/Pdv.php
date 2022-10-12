<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdv extends Model
{
    use HasFactory;

    protected $table = 'pdv';

    protected $fillable = [
        'id',
        'nome_responsavel',
        'nome_fantasia',
        'cnpj',
        'celular_responsavel',
        'limite_venda_pos',
    ];


}
