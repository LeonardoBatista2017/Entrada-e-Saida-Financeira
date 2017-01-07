<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Painel\Empreendimentos;
use App\Models\Painel\Entradas;
use App;
class UtilitiesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf() {
       $empreendimentos=DB::table('entrada')
               ->join('empreendimento', 'entrada.codigo_empreendimento', '=', 'empreendimento.codigo')
                    
                   ->select('empreendimento.nome as nome','empreendimento.codigo as codigo', 'entrada.valor_entrada as valor_entrada', 'entrada.data_da_entrada as data_da_entrada')
                    ->orderBy('entrada.data_da_entrada', 'desc')
                   ->get();

       
 $entradas=Entradas::with('empreendimentos')->with('saidas')->get();



//$resultados = DB::table('entrada')
            //    -> leftjoin('saida', 'saida.codigo_entrada', '=', 'entrada.codigo')
             //   ->join('empreendimento', 'entrada.codigo_empreendimento', '=', 'empreendimento.codigo')
              //  ->select('saida.codigo as codigo', 'saida.codigo_entrada as codigo_entrada','empreendimento.nome as nome', 'entrada.valor_entrada as valor_entrada', 'saida.valor_saida as valor_saida', 'entrada.data_da_entrada as data_da_entrada', 'saida.nome_valor_saida as nome_valor_saida')
              //  ->orderBy('saida.codigo_entrada', 'desc')
              //  ->get();

  // $listaArrayBalanco = array();             
//dentro de um for
   //$arrayBalanco = array ();

  // $arrayBalanco['empreendimento'] = $resultados[0]->nome;
                
    //for(){
       //if($arrayBalanco['empreendimento']==){

      // } 
   // }

   //array_push($listaArrayBalanco,$arrayBalanco);
    //dd($listaArrayBalanco);           
                 
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('painel.utilities.pdf.pdf', compact('empreendimentos','entradas')));

        return $pdf->stream();
        //return view('painel.utilities.pdf.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
