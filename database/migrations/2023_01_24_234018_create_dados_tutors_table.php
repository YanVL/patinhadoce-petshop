<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_tutors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome', 50);
            $table->string('telefone', 20);
            $table->string('email', 50);
            $table->integer('genero')->nullable();
            $table->string('endereco', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_tutors', function (Blueprint $table) {
            $table->dropColum('id');
            $table->dropColum('timestamps');
            $table->dropColum('nome');
            $table->dropColum('telefone');
            $table->dropColum('email');
            $table->dropColum('genero');
            $table->dropColum('endereco');
        });
    }
};
