<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tributacao extends Model
{
    //
    protected $table = 'tributacoes';
    protected $fillable = [
        'nome',
        'pis_aliquota_porcentual',
        'cofins_aliquota_porcentual',
        'icms_aliquota',
        'cfop_id',
        'icms_origem_id',
        'icms_situacao_tributaria_id',
        'pis_situacao_tributaria_id',
        'cofins_situacao_tributaria_id',
        'ativo',
        'company_id',

    ];
}
