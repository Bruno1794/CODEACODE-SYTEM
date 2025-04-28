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
        Schema::create('tributacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('pis_aliquota_porcentual', 5, 2)->default(0);
            $table->decimal('cofins_aliquota_porcentual', 5, 2)->default(0);
            $table->decimal('icms_aliquota', 5, 2)->default(0);
            $table->foreignId('cfop_id')->nullable()->constrained('cfops');
            $table->foreignId('icms_origem_id')->nullable()->constrained('icms_origem');
            $table->foreignId('icms_situacao_tributaria_id')->nullable()->constrained('icms_situacao_tributaria');
            $table->foreignId('pis_situacao_tributaria_id')->nullable()->constrained('pis_situacao_tributaria');
            $table->foreignId('cofins_situacao_tributaria_id')->nullable()->constrained('cofins_situacao_tributaria');
            $table->boolean('ativo')->default(1); // 1 para ativo e 0 para false
            $table->foreignId('company_id')->constrained('companys');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tributacoes');
    }
};
