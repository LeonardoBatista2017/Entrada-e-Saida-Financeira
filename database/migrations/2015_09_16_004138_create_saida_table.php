<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saida', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('codigo');
            $table->string('valor_saida', 100);
            $table->string('nome_valor_saida', 100);
             $table->integer('codigo_entrada')->unsigned();
            $table->foreign('codigo_entrada')->references('codigo')->on('entrada')->onDelete('cascade');
             
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Shema::drop('saida');
    }
}
