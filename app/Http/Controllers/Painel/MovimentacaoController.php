<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Painel\Empreendimentos;
use App\Models\Painel\Entradas;
use App\Models\Painel\Movimentacao;
use Illuminate\Validation\Factory;

class MovimentacaoController extends Controller
{
    private $totalItensPorPagina = 10;
    private $request;
    private $entrada;
    private $validator;
    
    public function __construct(Request $request,Factory $validator,Entradas $entrada) {
        $this->request=$request;
        $this->entrada=$entrada;
        $this->validator=$validator;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function getIndex(){
         
         
       $entradas=DB::table('entrada')
               ->join('empreendimento', 'entrada.codigo_empreendimento', '=', 'empreendimento.codigo')
                    
                   ->select('entrada.codigo as codigo', 'empreendimento.nome as nome', 'entrada.valor_entrada as valor_entrada', 'entrada.data_da_entrada as data_da_entrada')
                    ->orderBy('entrada.data_da_entrada', 'desc')
                   ->get();
        
      
        
       
       $estabelecimentos = DB::table('empreendimento')
       ->select('empreendimento.codigo as codigo','empreendimento.nome as nome')
											->get();
											

        return view('painel.movimentacao.index',compact('estabelecimentos','entradas'));
        
    }
    
    
    
   public function postAdicionarEntrada(){
     
        $dadosForm = $this->request->all();
       
        //$validator = $this->validator->make($dadosForm);
        
       // if($validator->fails()){
         //   $messages = $validator->messages();
            
          //  $displayErrors = '';
            
            //foreach($messages->all("<p>:message</p>") as $error){
              //  $displayErrors .= $error;
           // }
            
            //return $displayErrors;
        //}
       // $dadosForm['data_da_entrada'] = \Carbon\Carbon::createFromFormat('d/m/Y', $dadosForm['data_da_entrada'])->toDateString();
       
        $this->entrada->create($dadosForm);
        
        return 1;
    }
    
  public function getEditar($codigo){
        return $this->entrada->find($codigo)->toJson();
    }
    
    
    public function postEditar($codigo){
        $dadosForm = $this->request->all();
        
        $validator = $this->validator->make($dadosForm, Aluno::$rules);
        if($validator->fails()){
            $messages = $validator->messages();
            
            $displayErrors = '';
            
            foreach($messages->all("<p>:message</p>") as $error){
                $displayErrors .= $error;
            }
            
            return $displayErrors;
        }
       
        $this->entrada->find($codigo)->update($dadosForm);
        
        return 1;
    }
    
    public function getDeletar($codigo){
        $entradas = $this->entrada->find($codigo);
       
        $entradas->delete();
        
        return 1;
    }
    
    
    public function getPais($id){
        $aluno = $this->aluno->find($id);
         $dadosForm['data_nascimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $dadosForm['data_nascimento'])->toDateString();
        
        $pais = $aluno->getPais()->paginate($this->totalItensPorPagina);
        
        $titulo = "Pais do Aluno: {$aluno->nome}";
        
        $paisAdd = \App\Models\Painel\Pai::lists('nome', 'id');
        
        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id'));
    }
    
    
    public function postAdicionarPai($idAluno){
        $this->aluno->find($idAluno)->getPais()->sync($this->request->get('id_pai'));
        
        return 1;
    }
    
    
    public function getDeletarPai($idAluno, $idPai){
        return $this->aluno->find($idAluno)->getPais()->detach($idPai);
    }
    
    
    public function getPesquisar($palavraPesquisa = ''){
        $alunos = $this->aluno->where('nome', 'LIKE', "%{$palavraPesquisa}%")->paginate($this->totalItensPorPagina);
        
        $turmas = Turma::lists('nome', 'id');
        
        $titulo = "Resultados para a pesquisa: {$palavraPesquisa}";
        
        return view('painel.alunos.index', compact('alunos', 'turmas', 'titulo', 'palavraPesquisa'));
    }
    
    public function getPesquisarPais($id, $palavraPesquisa){
        $aluno = $this->aluno->find($id);
        
        $pais = $aluno->getPais()->where('nome', 'LIKE', "%$palavraPesquisa%")->paginate($this->totalItensPorPagina);
        
        $titulo = "Resultados para a pesquisa: $palavraPesquisa | Aluno: {$aluno->nome}";
        
        $paisAdd = \App\Models\Painel\Pai::lists('nome', 'id');
        
        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id', 'palavraPesquisa'));
    }
}
