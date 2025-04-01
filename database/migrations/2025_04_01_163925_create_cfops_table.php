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
        Schema::create('cfops', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 4);
            $table->string('descricao');
            $table->boolean('active')->default(1); // 1: Ativo - 0: Inativo
            $table->foreignId('natureza_operacoes_id')->constrained('natureza_operacoes');
            $table->foreignId('company_id')->constrained('companys');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfops');
    }
};
