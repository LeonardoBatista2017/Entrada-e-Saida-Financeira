<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Painel\Saidas;
use App\Models\Painel\Entradas;
use App\Models\Painel\Matricula;
use Illuminate\Validation\Factory;

class SaidaController extends Controller {

    private $totalItensPorPagina = 10;
    private $request;
    private $entrada;
    private $saida;
    private $validator;

    public function __construct(Request $request, Saidas $saida, Entradas $entrada, Factory $validator) {
        $this->request = $request;
        $this->saida = $saida;
        $this->entrada = $entrada;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex($codigo) {

        $resultados = DB::table('saida')
                ->join('entrada', 'saida.codigo_entrada', '=', 'entrada.codigo')
                ->select('saida.codigo as codigo', 'entrada.valor as valor', 'saida.valor as valor', 'entrada.data_da_entrada as data_da_entrada')
                ->where('saida.codigo_entrada', '=', '$codigo')
                ->orderBy('entrada.data_da_entrada', 'desc')
                ->get();





        return view('painel.saida.index', compact('resultados'));
    }

    public function getAdicionarSaida($codigo) {

        $entradas = DB::table('entrada')->where('codigo', '=', [$codigo])->get();


        $resultados = DB::table('saida')->where('codigo_entrada', '=', [$codigo])
                ->join('entrada', 'saida.codigo_entrada', '=', 'entrada.codigo')
                ->select('saida.codigo as codigo', 'saida.codigo_entrada as codigo_entrada', 'entrada.valor_entrada as valor_entrada', 'saida.valor_saida as valor_saida', 'entrada.data_da_entrada as data_da_entrada', 'saida.nome_valor_saida as nome_valor_saida')
                ->get();



        //busca o valor da entrada, retorna apenas esse valor
        $valor_entrada = DB::table('entrada')->where('codigo', '=', [$codigo])
                ->first();

        $nome_estabelecimento = DB::table('entrada')
                ->join('empreendimento', 'entrada.codigo_empreendimento', '=', 'empreendimento.codigo')
                ->select('empreendimento.nome as nome')
                ->first();

        $total_despesas = DB::table('saida')->where('codigo_entrada', '=', [$codigo])->sum('valor_saida');

        $lucro = $valor_entrada->valor_entrada - $total_despesas;





        return view('painel.saida.index', compact('resultados', 'codigo', 'entradas', 'total_despesas', 'lucro', 'valor_entrada', 'nome_estabelecimento'));
    }

    public function postAdicionarSaida() {

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


        $this->saida->create($dadosForm);




        return 1;
    }

    public function getDeletar($codigo) {
        $saidas = $this->saida->find($codigo);

        $saidas->delete();

        return 1;
    }

    public function getEditar($codigo) {
        return $this->saida->find($codigo)->toJson();
    }

    public function postEditar($codigo) {
        $dadosForm = $this->request->all();




        $this->saida->find($codigo)->update($dadosForm);

        return 1;
    }

    public function getPais($id) {
        $aluno = $this->aluno->find($id);

        $pais = $aluno->getPais()->paginate($this->totalItensPorPagina);

        $titulo = "Pais do Aluno: {$aluno->nome}";

        $paisAdd = \App\Models\Painel\Pai::lists('nome', 'id');

        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id'));
    }

    public function postAdicionarPai($idAluno) {
        $this->aluno->find($idAluno)->getPais()->sync($this->request->get('id_pai'));

        return 1;
    }

    public function getDeletarPai($idAluno, $idPai) {
        return $this->aluno->find($idAluno)->getPais()->detach($idPai);
    }

    public function getPesquisar($palavraPesquisa = '') {
        $alunos = $this->aluno->where('nome', 'LIKE', "%{$palavraPesquisa}%")->paginate($this->totalItensPorPagina);

        $turmas = Turma::lists('nome', 'id');

        $titulo = "Resultados para a pesquisa: {$palavraPesquisa}";

        return view('painel.alunos.index', compact('alunos', 'turmas', 'titulo', 'palavraPesquisa'));
    }

    public function getPesquisarPais($id, $palavraPesquisa) {
        $aluno = $this->aluno->find($id);

        $pais = $aluno->getPais()->where('nome', 'LIKE', "%$palavraPesquisa%")->paginate($this->totalItensPorPagina);

        $titulo = "Resultados para a pesquisa: $palavraPesquisa | Aluno: {$aluno->nome}";

        $paisAdd = \App\Models\Painel\Pai::lists('nome', 'id');

        return view('painel.alunos.pais', compact('aluno', 'pais', 'titulo', 'paisAdd', 'id', 'palavraPesquisa'));
    }

}
