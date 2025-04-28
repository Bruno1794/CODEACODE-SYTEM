<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icms_situacao_tributaria extends Model
{
    //
    protected $table = 'icms_situacao_tributaria';
    protected $fillable = ['codigo', 'descricao'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
