@extends('painel.templates.index')

@section('content')

<h1 class="titulo-pg-painel">Cadastro de Entrada</h1>

<div class="divider"></div>

<div class="container">

            <div class="col-md-3">
                
            <div class="modal-body">
                <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
                <div class="alert alert-success msg-suc" role="alert" style="display: none"></div>
            <form class="form-padrao form-gestao"  method="POST" action="movimentacao/adicionar-entrada" send="movimentacao/adicionar-entrada">
                    {!! csrf_field() !!}
                    
                     <div class="form-group">
                       
                           <label for="codigo_empreendimento" class="control-label">Nome do  Estabelecimento:</label>
                        <select name="codigo_empreendimento" class="form-control">
                            @foreach($estabelecimentos as $estabelecimento)                    

                            <option value="{{$estabelecimento->codigo}}">{{$estabelecimento->nome}}</option>
                             
                             @endforeach
                         
                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        Data:<input type="date" name="data_da_entrada" class="form-control" >
                    </div>
                    <div class="form-group">
                        R$:<input type="text" name="valor_entrada" class="form-control" placeholder="Valor de Entrada">
                    </div>
                    
                    <div class="preloader" style="display: none">Enviando os dados, por favor aguarde...</div>
            </div> 
                   
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
               
             </div>





</div>

<div class="divider"></div>

<table class="table table-hover">
    <tr>
        <th>Data da Entrada</th>
        <th>Estabelecimento</th>
        
        <th>Valor de Entrada</th>

        <th width="120px;"></th>
    </tr>
    @forelse($entradas as $entrada)
    <tr class="active">
        <td><?php echo date('d/m/Y', strtotime($entrada->data_da_entrada)); ?> </td>
        <td>{{$entrada->nome}}</td>
        
        <td>{{$entrada->valor_entrada}}</td>
        


        <td>

            <a href="{{url("/painel/saida/$entrada->codigo/adicionar-saida")}}" class="btn-saida">SAIDA
             
            </a>
            
            <a class="delete" onclick="del('entrada/deletar/{{$entrada->codigo}}')">
                <i class="fa fa-times"></i>
            </a>

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="500">Nenhuma Entrada cadastrada!</td>
    </tr>

    @endforelse


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
                        <input type="text" name="data_da_entrada" class="form-control" placeholder="Valor de Saída">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="valor" class="form-control" placeholder="Valor de Saída">
                    </div>
                    <div class="form-group">
                        <input type="text" name="codigo_empreendimento"  class="form-control" placeholder="Informação de Saída">
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