<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpreendimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('empreendimento', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('codigo');
            $table->string('nome', 150);
            $table->string('telefone',15);
            $table->string('tipo_de_recebimento',150);
            
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
        Schema::drop('empreendimento');
    }
}
