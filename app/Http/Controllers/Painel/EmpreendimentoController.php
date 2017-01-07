<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Validation\Factory;
use App\Models\Painel\Empreendimentos;


class EmpreendimentoController extends Controller
{
    private $totalItensPorPagina = 15;
    private $request;
    private $empreendimento;
    private $validator;
    
    public function __construct(Request $request,Empreendimentos $empreendimento,Factory $validator) {
        $this->request=$request;
        $this->empreendimento=$empreendimento;
        $this->validator=$validator;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    
   
     public function postAdicionarEmpreendimento(){
         
     
       
        $dadosForm=$this->request->all();
       
          $validator = $this->validator->make($dadosForm, Empreendimentos::$rules);
          
         if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }
        
        $this->empreendimento->create($dadosForm);
        
        
        return 1;
          
         
    }
    
    public function getEditar($codigo){
        return $this->empreendimento->find($codigo)->toJson();
    }
    
    public function postEditar($codigo){
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, Empreendimentos::$rules);
        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }
        
        
        $this->empreendimento->find($codigo)->update($dadosForm);
        
        return 1;
    }
    
     public function getPesquisar($palavraPesquisa = ''){
        $empreendimentos = $this->empreendimento->where('telefone', 'LIKE', "%{$palavraPesquisa}%")->paginate($this->totalItensPorPagina);
        

        
        $titulo = "Resultados para a pesquisa: {$palavraPesquisa}";
        
        return view('painel.pessoas.index', compact('empreendimentos', 'titulo', 'palavraPesquisa'));
    }
    
    
     public function getIndex(){
        $empreendimentos = $this->empreendimento->paginate(5);
        
        
        return view('painel.pessoas.index',  compact('empreendimentos'));
    }
    
    public function getDeletar($codigo){
        $empreendimentos = $this->empreendimento->find($codigo);
  
        $empreendimentos->delete();
        
        return 1;
    }
    
   
  
    
    //este método é para quando digitarem uma url que não pertence a esta rota
    /*
    public function missingMethod($params=array()){
        
        return 'Erro 4042';
    }
    */
   
   
}
