<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'companys';
    protected $fillable = [
        'id_nf',
        'name',
        'cpf_cnpj',
        'name_fantasy',
        'address',
        'number_addres',
        'district_addres',
        'city',
        'cep',
        'state',
        'inscription_state',
        'phone',
        'date_expiration',
        'status',
        'regime_tributario',
        'token_producao',
        'token_homogacao',
        'user_id',
    ];
}
