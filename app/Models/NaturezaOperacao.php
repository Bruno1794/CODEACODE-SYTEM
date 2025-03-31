<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaturezaOperacao extends Model
{
    //
    protected $table = 'natureza_operacoes';
    protected $fillable = [
        'nome_natureza_operacao',
        'tipo_natureza_operacao',
        'active',
        'company_id',

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
