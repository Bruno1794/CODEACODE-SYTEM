<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CFOP extends Model
{
    //
    protected $table = 'cfops';
    protected $fillable = [
        'codigo',
        'descricao',
        'natureza_operacoes_id',
        'active',
        'company_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
