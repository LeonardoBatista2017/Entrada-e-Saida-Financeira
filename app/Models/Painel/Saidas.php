<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Saidas extends Model {

      public $timestamps = false;
	protected $table = 'saida';
	protected $primaryKey = 'codigo';
	
    
    
    protected $guarded = ['codigo'];
    static $rules = [
        'nome' => 'required|min:3|max:60',
        'telefone' => 'required|min:10|max:11',
        'tipo_de_recebimento' => 'required|min:3|max:60',
       
    ];

}
