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
        Schema::create('companys', function (Blueprint $table) {
            $table->id();
            $table->string('id_nf');//Id Referencia do cadastro na API FOCUS
            $table->string('name');
            $table->string('cpf_cnpj')->unique();
            $table->string('name_fantasy');
            $table->string('address');
            $table->string('number_addres');
            $table->string('district_addres');//bairro
            $table->string('city');
            $table->string('state');
            $table->string('cep');
            $table->string('inscription_state');
            $table->string('phone');
            $table->date('date_expiration');
            $table->boolean('status')->default(1); // 0 Inativo e 1 ativo
            $table->integer('regime_tributário')->default(1); // 1 = Simples Nacional, 2 = Simples Nacional - Excesso de Sublimite, 3 = Regime Normal'
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
