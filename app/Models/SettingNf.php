<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingNf extends Model
{
    //
    protected $table = 'settings_nfs';
    protected $fillable = [
        'cpf_cnpj_contabilidade',
        'habilita_nfe',
        'habilita_nfce',
        'exibe_impostos_adicionais_danfe',
        'exibe_unidade_tributaria_danfe',
        'exibe_sempre_volumes_danfe',
        'enviar_email_destinatario',
        'discrimina_impostos',
        'csc_nfce_producao',
        'id_token_nfce_producao',
        'csc_nfce_homologacao',
        'id_token_nfce_homologacao',
        'proximo_numero_nfe_producao',
        'proximo_numero_nfe_homologacao',
        'serie_nfe_producao',
        'serie_nfe_homologacao',
        'serie_nfce_producao',
        'serie_nfce_homologacao',
        'company_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
