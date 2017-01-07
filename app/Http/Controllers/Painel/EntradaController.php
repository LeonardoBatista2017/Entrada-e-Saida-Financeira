<?php

namespace App\Http\Controllers\Painel;
use DB;
use App\Models\Painel\Carro;
use Illuminate\Http\Request;
use Validator;
use \App\Models\Painel\Entradas;
use  App\Http\Controllers\Controller;
use Cache;
use Crypt;

class EntradaController extends Controller{
    
    private $entrada;
    private $request;
    private $validator;
    
    public function __construct(Entradas $entrada, Request $request, \Illuminate\Validation\Factory $validator) {
        $this->entrada=$entrada;
        $this->request=$request;
        $this->validator=$validator;
    }
    
    
	public function getIndex(){

                 $carros =$this->carro->paginate(2);//injeção de dependência
		return view('painel.carros.index', compact('carros'));
	}

	

	public function postAdicionarEntrada(Request $request){

		

		/*caso queira pegar todos os campos do formulário
		sem a necessidade de preencher muitos inputs
		fazer da forma abaixo*/

		//$dadosForm = $request->all(); //captura todos os dados do formulário

		$dadosForm = $request->except('file');

		

		//$validator = Validator::make ($dadosForm,Carro::$rules); //auto acoplamento
                
                $validator = $this->validator->make ($dadosForm,Carro::$rules);
		if ($validator -> fails()){
			return redirect ('painel/carros/adicionar')
			->withErrors ($validator)
			->withInput ();
		}

		$file = $this->request->file('file');



		if ($this->request->hasFile('file') && $file->isValid() ){

				if($file-> getClientMimeType() =="image/jpeg" || $file-> getClientMimeType() =="image/png"){
					$file->move('assets/uploads/images', $file->getClientOriginalName() );
				}

			
		}

	

		   //return Carro::create($dadosForm);// com o return antes consegue-se vizualizar as informações que estão sendo inseridas bem como seu id
			//$carro= Carro::create($dadosForm);//auto acoplamento
                $carro= $this->carro->create($dadosForm);
           return redirect("painel/carros/editar/$carro->id");

		//return redirect ('carros/adicionar')->withInput();
	}

	public function getEditar($idCarro){
		$carro = $this->carro->find($idCarro); //o método find busca as propriedades de carro
                 //busca todas as marcas de carros
                $marcas=MarcasCarro::lists('marca','id');
		//dd($carro); //vizualiza todas as propriedades do carro e exibe na tela
		//return view('painel.carros.create-edit', ['idCarro' => $idCarro, 'nome' => $carro->nome, 'placa' => $carro->placa]);
		return view('painel.carros.create-edit', compact('carro','marcas'));
	}

	public function postEditar( $idCarro){
		//return "Editando o carro: {$idCarro}";
		$dadosForm = $this->request->except('_token');
                
                 $rulesEdit = [
		'nome'=> 'required |min:3|max:100',
		'placa' => "required |min:7|max:7|unique:carros,placa,$idCarro",


		];

       $validator = $this->validator->make ($dadosForm,Carro::$rules);

		if ($validator -> fails()){
			return redirect ("painel/carros/editar/$idCarro")
			->withErrors ($validator)
			->withInput ();
		}


		Carro::where('id', $idCarro)->update($dadosForm,$rulesEdit);

           return redirect('painel/carros');

	}
	public function getDeletar($codigo){
		//return "Deletando o carro: ->{$idCarro}";
		//$carro = Carro::find($idCarro);//auto acoplamento
                $entradas = $this->entrada->find($codigo);
		$entradas->delete();
		 return 1;
	}

	public function getListaCarrosLuxo(){
		return 'listando os carros de luxo';
	}
	public function missingMethod($params = array()){
		return 'Erro 404';
	}


	public function getListarCarrosCache(){
		//Cache::put('carros', Carro::all(), 3);
		//$carros=Cache::get('carros', 'Não existe Carros');
		$carros=Cache::remember ('carros',3,function(){

			return Carro::all();
		});

		//$titulo='Cache Carros';
		$titulo=Crypt::encrypt('Cache Carros');
		return view ('painel.carros.cache', compact('carros','titulo'));


		//return $carros;
	}
}