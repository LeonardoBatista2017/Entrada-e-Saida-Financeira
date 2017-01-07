@extends('painel.templates.index')

@section('content')

<h1 class="titulo-pg-painel">Cadastro de Saída ({{$nome_estabelecimento->nome}} - <?php echo date('d/m/Y', strtotime($valor_entrada->data_da_entrada)); ?>)</h1>   


<div class="divider"></div>

<div class="container">

    <div class="col-md-4">

        <div class="modal-body">
            <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
            <div class="alert alert-success msg-suc" role="alert" style="display: none"></div>
            <form class="form-padrao form-gestao"  method="POST" action="adicionar-saida" send="adicionar-saida">
                {!! csrf_field() !!}

                <div class="form-group">


                    <div class="form-group">
                        <input type="hidden" name="codigo_entrada" class="form-control" value="{{$codigo}}" >
                    </div>
                   
                    <div class="form-group">
                        Descreva a Saida:<input type="text" name="nome_valor_saida" placeholder="Descreva a Saida" class="form-control" >
                    </div>

                    <div class="form-group">
                        R$:<input type="text" name="valor_saida" class="form-control" placeholder="Valor de Saida">
                    </div>

                    <div class="preloader" style="display: none">Enviando os dados, por favor aguarde...</div>
                </div> 

                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>

        </div>





    </div>
    
     <div class="col-md-4">
      <table class="table table-bordered">
          
          <tr>
              <th >DATA</th>
          <th><?php echo date('d/m/Y', strtotime($valor_entrada->data_da_entrada)); ?> </th>
          </tr>
          <th >Estabelecimento</th>
          
          <th>{{$nome_estabelecimento->nome}}</th>
          


  <tr>
      <td class="success"> Entrada</td>
      <td class="success"> {{$valor_entrada->valor_entrada}}</td>
  </tr> 
    <tr>
        <td class="danger">Subtotal de Despesas</td>
        <td class="danger"> -{{$total_despesas}}</td>
   </tr>
   <tr>
       <td class="info">Lucro</td>
       <td class="info">{{$lucro}}</td>
    
    </tr>




       

          
          
          </table>
      </div>

</div>
<div class="divider"></div>


<table class="table  table-bordered">
    <th class="danger">Descrição da Despesa</th>
    <th class="danger">Valor da Saida</th>
    <th class="danger"></th>



    @forelse($resultados as $resultado)




    <tr class="danger" >



        <td>{{$resultado->nome_valor_saida}}</td>
        <td>-{{$resultado->valor_saida}}</td>
     





        <td>

            <a class="edit"  onclick="edit('/thyca/public/painel/saida2/editar/{{$resultado->codigo}}')">
                <i class="fa fa-pencil-square-o"></i>
            </a>

            <a class="delete" onclick="del('/thyca/public/painel/saida2/deletar/{{$resultado->codigo}}')">
                <i class="fa fa-times"></i>
            </a>

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="500">Nenhuma Saida de Caixa cadastrada!</td>
    </tr>
 
    @endforelse

      <td class="danger fonte_subtotal_despesas">Subtotal de Despesas:</td>
      <td class="danger fonte_subtotal_despesas">-{{$total_despesas}}</td>
      <td class="danger"></td>
</table>




@endsection

<!-- Modal Para Gestão -->
<div class="modal fade" id="modalGestao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-padrao4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Saída de Caixa</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
                <div class="alert alert-success msg-suc" role="alert" style="display: none"></div>

                <form class="form-padrao form-gestao"  method="POST" action="saida/adicionar-saida" send="saida/adicionar-saida">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <input type="hidden" name="codigo_entrada" class="form-control" value="{{$codigo}}" >
                    </div>

                    <div class="form-group">
                        Descreva a Saida:<input type="text" name="nome_valor_saida" placeholder="Descreva a Saida" class="form-control" >
                    </div>

                    <div class="form-group">
                        R$:<input type="text" name="valor_saida" class="form-control" placeholder="Valor de Saida">
                    </div>




                    <div class="prelaoder" style="display: none">Enviando os dados, por favor aguarde...</div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>

                </form>
            </div>
        </div>
    </div>
</div>





@section('scripts')    
<script>
    var urlAdd = 'movimentacao/adicionar-saida';
</script>
@endsection