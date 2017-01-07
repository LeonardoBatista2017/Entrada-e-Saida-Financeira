<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Entradas extends Model {

      public $timestamps = false;
	protected $table = 'entrada';
	protected $primaryKey = 'codigo';
        
	 public function saidas(){
        return $this->hasMany('App\Models\Painel\Saidas','codigo_entrada');
    }
    
     public function empreendimentos(){
      
         return $this->hasMany('App\Models\Painel\Empreendimentos','codigo','codigo_empreendimento');
    }
    //hasMany('App\Models\Painel\Empreendimentos','codigo');
    
    
    protected $guarded = ['codigo'];
    static $rules = [
        'nome' => 'required|min:3|max:60',
        'telefone' => 'required|min:10|max:11',
        'tipo_de_recebimento' => 'required|min:3|max:60',
       
    ];

}
