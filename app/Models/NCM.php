<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NCM extends Model
{
    //
    protected $table = 'ncms';
    protected $fillable = [
        'nome_ncm',
        'codigo_ncm',
        'active',
        'active',
        'company_id',
    ];

}
