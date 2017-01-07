<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Empreendimentos extends Model {

      public $timestamps = false;
	protected $table = 'empreendimento';
	protected $primaryKey = 'codigo';
	
   
    
   

    protected $guarded = ['codigo'];
    static $rules = [
        'nome' => 'required|min:3|max:60',
        'telefone' => 'required|min:10|max:14',
        'tipo_de_recebimento' => 'required|min:3|max:60',
       
    ];

}
