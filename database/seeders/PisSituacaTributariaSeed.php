<?php

namespace Database\Seeders;

use App\Models\Pis_situacao_tributaria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PisSituacaTributariaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (!Pis_situacao_tributaria::where('codigo', '=', '01')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '01',
                'descricao' => 'Operação tributável: base de cálculo = valor da operação (alíquota normal –
                cumulativo/não cumulativo)'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '02')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '02',
                'descricao' => 'Operação tributável: base de cálculo = valor da operação (alíquota diferenciada)'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '03')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '03',
                'descricao' => 'Operação tributável: base de cálculo = quantidade vendida × alíquota por unidade de produto'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '04')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '04',
                'descricao' => 'Operação tributável: tributação monofásica (alíquota zero)'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '05')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '05',
                'descricao' => 'Operação tributável: substituição tributária'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '06')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '06',
                'descricao' => 'Operação tributável: alíquota zero'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '07')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '07',
                'descricao' => 'Operação isenta da contribuição'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '08')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '08',
                'descricao' => 'Operação sem incidência da contribuição'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '09')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '09',
                'descricao' => 'Operação com suspensão da contribuição'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '49')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '49',
                'descricao' => 'Outras operações de saída'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '50')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '50',
                'descricao' => 'Operação com direito a crédito: vinculada exclusivamente a receita tributada no
                 mercado interno'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '51')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '51',
                'descricao' => 'Operação com direito a crédito: vinculada exclusivamente a receita não tributada no
                mercado interno'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '52')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '52',
                'descricao' => 'Operação com direito a crédito: vinculada exclusivamente a receita de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '53')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '53',
                'descricao' => 'Operação com direito a crédito: vinculada a receitas tributadas e não-tributadas no
                mercado interno'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '54')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '54',
                'descricao' => 'Operação com direito a crédito: vinculada a receitas tributadas no mercado interno e
                 de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '55')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '55',
                'descricao' => ' Operação com direito a crédito: vinculada a receitas não-tributadas no mercado
                 interno e de exprtação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '56')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '56',
                'descricao' => 'Operação com direito a crédito: vinculada a receitas tributadas e não-tributadas no
                 mercado interno e de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '60')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '60',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada exclusivamente a receita tributada
                no mercado interno'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '61')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '61',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada exclusivamente a receita não-tributada
                 no mercado interno'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '62')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '62',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada exclusivamente a receita de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '63')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '63',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada a receitas tributadas e não-tributadas
                 no mercado interno'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '64')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '64',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada a receitas tributadas no mercado interno
                 e de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '65')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '65',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada a receitas não-tributadas no mercado
                interno e de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '66')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '66',
                'descricao' => 'Crédito presumido: operação de aquisição vinculada a receitas tributadas e não-tributadas
                no mercado interno e de exportação'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '67')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '67',
                'descricao' => 'Crédito presumido: outras operações'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '70')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '70',
                'descricao' => 'Operação de aquisição sem direito a crédito'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '71')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '71',
                'descricao' => 'Operação de aquisição com isenção'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '72')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '72',
                'descricao' => 'Operação de aquisição com suspensão'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '73')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '73',
                'descricao' => 'Operação de aquisição a alíquota zero'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '74')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '74',
                'descricao' => 'Operação de aquisição sem incidência da contribuição'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '75')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '75',
                'descricao' => 'Operação de aquisição por substituição tributária'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '98')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '98',
                'descricao' => 'Outras operações de entrada'
            ]);
        }

        if (!Pis_situacao_tributaria::where('codigo', '=', '99')->exists()) {
            Pis_situacao_tributaria::create([
                'codigo' => '99',
                'descricao' => 'Outras operações'
            ]);
        }
    }
}
