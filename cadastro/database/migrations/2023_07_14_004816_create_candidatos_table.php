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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->integer('cpf')->length(14)->unsigned()->unique();
            $table->char('sexo', 1 );
            $table->string('nome_mae', 100);
            $table->date('dt_nascimento');
            $table->string('escolaridade', 50);
            $table->string('vinculo', 50);
            $table->string('endereco', 70);
            $table->string('complemento', 70)->nullable();
            $table->string('bairro', 70);
            $table->string('cidade', 20);
            $table->char('uf', 2);
            $table->string('cep')->length(10);
            $table->string('rg');
            $table->string('org_exp');
            $table->date('dt_emissao');
            $table->string('telefone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
