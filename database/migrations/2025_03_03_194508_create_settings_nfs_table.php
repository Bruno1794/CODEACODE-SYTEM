<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*BOLLEAN 0: DESATIVADO E 1: ATIVO*/
        Schema::create('settings_nfs', function (Blueprint $table) {
            $table->id();

            //CPF/CNPJ da contabilidade da empresa. Alguns estados necessitam que esta informação seja adicionado (no momento apenas BA obriga).
            $table->integer('cpf_cnpj_contabilidade')->nullable();

            //Informa se empresa será habilitada para emissão de NFe – Nota Fiscal Eletrônica modelo 55
            $table->boolean('habilita_nfe')->default(0);

            //Informa se empresa será habilitada para emissão de NFCe – Nota Fiscal ao Consumidor Eletrônica modelo 65
            $table->boolean('habilita_nfce')->default(0);

            //Informa se empresa será habilitada para imprimir impostos adicionais na DANFe (II, PIS, COFINS, ICMS UF
            // Destino, ICMS UF Remetente, valor total tributos)
            $table->boolean('exibe_impostos_adicionais_danfe')->default(0);

            //Informa se empresa será habilitada para exibir unidade tributária na DANFe
            $table->boolean('exibe_unidade_tributaria_danfe')->default(0);

            //Informa se empresa será habilitada para sempre mostrar volumes na DANFe
            $table->boolean('exibe_sempre_volumes_danfe')->default(0);

            //Informa se empresa será habilitada para enviar email ao destinatário em produção
            $table->boolean('enviar_email_destinatario')->default(0);

            //Informa se empresa será habilitada para discriminar impostos de NFe e NFCe
            $table->boolean('discrimina_impostos')->default(0);

            //CSC para emissão de NFCe em ambiente de produção. Sem este campo não será possível emitir NFCe em produção.
            // Veja com o SEFAZ do seu estado como gerar este código.
            $table->string('csc_nfce_producao')->nullable();

            //Id do CSC para emissão de NFCe em ambiente de produção. Sem este campo não será possível emitir NFCe em
            // produção. Veja com o SEFAZ do seu estado como gerar este número.
            $table->integer('id_token_nfce_producao')->nullable();

            //CSC para emissão de NFCe em ambiente de homologação. Sem este campo não será possível emitir NFCe em homologação.
            $table->string('csc_nfce_homologacao')->nullable();

            //Id do CSC para emissão de NFCe em ambiente dehomologação. Sem este campo não será possível emitir NFCe em homologação.
            $table->integer('id_token_nfce_homologacao')->nullable();

            //Próximo número da NFe a ser emitida em produção. Calculado automaticamente.
            $table->integer('proximo_numero_nfe_producao')->nullable();

            //Próximo número da NFe a ser emitida em homologação. Calculado automaticamente.
            $table->integer('proximo_numero_nfe_homologacao')->nullable();

            //Série da NFe a ser emitida em produção. Valor padrão: 1
            $table->integer('serie_nfe_producao')->nullable();

            //Série da NFe a ser emitida em homologação. Valor padrão: 1
            $table->integer('serie_nfe_homologacao')->nullable();

            //Série da NFCe a ser emitida em produção. Valor padrão: 1
            $table->integer('serie_nfce_producao')->nullable();

            //Série da NFCe a ser emitida em homologação. Valor padrão: 1
            $table->integer('serie_nfce_homologacao')->nullable();

            //vincular configurações a empresa
            $table->foreignId('company_id')->constrained('companys');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_nfs');
    }
};
