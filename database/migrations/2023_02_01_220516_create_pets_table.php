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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->timestamps();
            $table->string('nome', 50);
            $table->string('especie', 15);
            $table->text('observacao', 200)->nullable();

            //constraint
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets', function (Blueprint $table) {
            //removendo a fk
            $table->dropForeign('pets_cliente_id_foreign');
            //removendo coluna
            $table->dropColum('id');
            $table->dropColum('timestamps');
            $table->dropColum('nome');
            $table->dropColum('especie');
            $table->dropColum('observacao');
        });
    }
};

