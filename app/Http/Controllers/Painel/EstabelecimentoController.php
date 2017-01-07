<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Painel\Aluno;
use App\Models\Painel\Turma;
use App\Models\Painel\Matricula;
use Illuminate\Validation\Factory;

class EstabelecimentoController extends Controller
{
    private $totalItensPorPagina = 10;
    private $request;
    private $aluno;
    private $validator;
    
    public function __construct(Request $request,Aluno $aluno,Factory $validator) {
        $this->request=$request;
        $this->aluno=$aluno;
        $this->validator=$validator;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function getIndex(){
        //$alunos = $this->aluno->paginate($this->totalItensPorPagina);
        $alunos = $this->aluno
                    ->join('matriculas', 'matriculas.id_aluno', '=', 'alunos.id')
                    ->join('turmas', 'turmas.id', '=', 'alunos.id_turma')
                    ->select('matriculas.numero as matricula', 'alunos.nome', 'alunos.telefone', 'alunos.data_nascimento', 'alunos.id', 'turmas.nome as turma')
                    ->paginate($this->totalItensPorPagina);
        
        $turmas = Turma::lists('nome', 'id');
        
        $titulo = 'Alunos';
        
        return view('painel.alunos.index', compact('alunos', 'turmas', 'titulo'));
    }
    
    
    
   public function postAdicionarEstabelecimento(){
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
        $dadosForm['data_nascimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $dadosForm['data_nascimento'])->toDateString();
        
        $aluno = $this->aluno->create($dadosForm);
        $matricula = ['id_aluno' => $aluno->id, 'numero' => uniqid($aluno->id)];
        Matricula::create($matricula);
        
        return 1;
    }
    
  public function getEditar($id){
        return $this->aluno->find($id)->toJson();
    }
    
    
    public function postEditar($id){
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
        $dadosForm['data_nascimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $dadosForm['data_nascimento'])->toDateString();
        
        $this->aluno->find($id)->update($dadosForm);
        
        return 1;
    }
    
    public function getDeletar($id){
        $aluno = $this->aluno->find($id);
        $aluno->getPais()->detach();
        $aluno->delete();
        
        return 1;
    }
    
    
    public function getPais($id){
        $aluno = $this->aluno->find($id);
        
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
