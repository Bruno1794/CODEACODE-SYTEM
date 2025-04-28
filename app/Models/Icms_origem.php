<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icms_origem extends Model
{
    //
    protected $table = 'icms_origem';
    protected $fillable = ['codigo','descricao'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
