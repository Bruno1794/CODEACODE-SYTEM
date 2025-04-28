<?php

namespace Database\Seeders;

use App\Models\Icms_situacao_tributaria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IcmsSituacaoTributariaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (!Icms_situacao_tributaria::where('codigo', '=', '00')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '00',
                'descricao' => 'Tributada integralmente'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '10')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '10',
                'descricao' => 'Tributada e com cobrança do ICMS por substituição tributária'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '20')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '20',
                'descricao' => 'Tributada com redução de base de cálculo'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '30')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '30',
                'descricao' => 'Isenta ou não tributada e com cobrança do ICMS por substituição tributária'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '40')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '40',
                'descricao' => 'Isenta'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '41')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '41',
                'descricao' => 'Não tributada'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '50')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '50',
                'descricao' => 'Suspensão'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '51')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '51',
                'descricao' => 'Diferimento (a exigência do preenchimento das informações do ICMS diferido fica a
                critério de cada UF)'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '60')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '60',
                'descricao' => 'Cobrado anteriormente por substituição tributária'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '70')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '70',
                'descricao' => 'Tributada com redução de base de cálculo e com cobrança do ICMS por substituição
                tributária; 90 – Outras (regime Normal)'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '101')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '101',
                'descricao' => 'Tributada pelo Simples Nacional com permissão de crédito'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '102')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '102',
                'descricao' => 'Tributada pelo Simples Nacional sem permissão de crédito'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '103')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '103',
                'descricao' => 'Isenção do ICMS no Simples Nacional para faixa de receita bruta'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '201')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '201',
                'descricao' => 'Tributada pelo Simples Nacional com permissão de crédito e com cobrança do ICMS por
                substituição tributária'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '202')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '202',
                'descricao' => 'Tributada pelo Simples Nacional sem permissão de crédito e com cobrança do ICMS por
                substituição tributária'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '203')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '203',
                'descricao' => 'Isenção do ICMS nos Simples Nacional para faixa de receita bruta e com cobrança do
                ICMS por substituição tributária'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '300')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '300',
                'descricao' => 'Imune'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '400')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '400',
                'descricao' => 'Não tributada pelo Simples Nacional'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '500')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '500',
                'descricao' => 'ICMS cobrado anteriormente por substituição tributária (substituído) ou por antecipação'
            ]);
        }

        if (!Icms_situacao_tributaria::where('codigo', '=', '900')->exists()) {
            Icms_situacao_tributaria::create([
                'codigo' => '900',
                'descricao' => 'Outras (regime Simples Nacional)'
            ]);
        }
    }

}
