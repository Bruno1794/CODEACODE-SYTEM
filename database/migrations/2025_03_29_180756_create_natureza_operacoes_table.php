<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('natureza_operacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_natureza_operacao');
            $table->enum('tipo_natureza_operacao', ['ENTRADA', 'SAIDA']);
            $table->boolean('active')->default(1);// 1: Ativo e 0: desativado
            $table->foreignId('company_id')->constrained('companys');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('natureza_operacoes');
    }
};
