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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->timestamps();
            $table->integer('tipo');
            $table->float('preco', 3, 2);

            //constraint
            $table->foreign('pet_id')->references('id')->on('pets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos', function (Blueprint $table) {
            //removendo a fk
            $table->dropForeign('servicos_pet_id_foreign');
            //removendo coluna
            $table->dropColumn(['id', 'timestamps', 'integer', 'preco']);
        });
    }
};
