<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cofins_situacao_tributaria extends Model
{
    //
    protected $table = 'cofins_situacao_tributaria';
    protected $fillable = ['codigo', 'descricao'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
