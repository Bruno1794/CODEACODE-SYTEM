<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //

    protected $table = 'certificates';
    protected $fillable = [
        'nome_certificado',
        'arquivo_certificado',
        'senha_certificado',
        'senha_certificado',
        'data_expiracao',
        'company_id',
    ];

    protected $casts = [
        'data_expiracao' => 'date',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
