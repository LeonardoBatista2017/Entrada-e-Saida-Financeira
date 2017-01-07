<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entrada', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('codigo');
            $table->string('valor_entrada', 100);
            $table->date('data_da_entrada');
 $table->integer('codigo_empreendimento')->unsigned();
            $table->foreign('codigo_empreendimento')->references('codigo')->on('empreendimento')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Shema::drop('entrada');
    }

}
