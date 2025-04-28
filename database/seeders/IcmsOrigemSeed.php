<?php

namespace Database\Seeders;

use App\Models\Icms_origem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IcmsOrigemSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (!Icms_origem::where('codigo', '=', '0')->exists()) {
            Icms_origem::create([
                'codigo' => '0',
                'descricao' => 'Nacional'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '1')->exists()) {
            Icms_origem::create([
                'codigo' => '1',
                'descricao' => 'Estrangeira (importação direta)'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '2')->exists()) {
            Icms_origem::create([
                'codigo' => '2',
                'descricao' => 'Estrangeira (adquirida no mercado interno)'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '3')->exists()) {
            Icms_origem::create([
                'codigo' => '3',
                'descricao' => 'Nacional com mais de 40% de conteúdo estrangeiro'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '4')->exists()) {
            Icms_origem::create([
                'codigo' => '4',
                'descricao' => 'Nacional produzida através de processos produtivos básicos'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '5')->exists()) {
            Icms_origem::create([
                'codigo' => '5',
                'descricao' => 'Nacional com menos de 40% de conteúdo estrangeiro'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '6')->exists()) {
            Icms_origem::create([
                'codigo' => '6',
                'descricao' => 'Estrangeira (importação direta) sem produto nacional similar'
            ]);
        }

        if (!Icms_origem::where('codigo', '=', '7')->exists()) {
            Icms_origem::create([
                'codigo' => '7',
                'descricao' => ' Estrangeira (adquirida no mercado interno) sem produto nacional similar'
            ]);
        }
    }
}
