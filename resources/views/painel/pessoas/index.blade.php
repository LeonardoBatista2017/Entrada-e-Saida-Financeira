@extends('painel.templates.index')

@section('content')



<h1 class="titulo-pg-painel">Listagem dos Estabelecimentos ({{$empreendimentos->count()}}) </h1>

<div class="divider"></div>

<div class="col-md-12">
    <form class="form-padrao form-inline padding-20 form-pesquisa" method="POST" send="pessoas/pesquisar/">
        <a href="" class="btn-cadastrar" data-toggle="modal" data-target="#modalGestao"><i class="fa fa-plus-circle"></i> Cadastrar</a>
        <input type="text" placeholder="Pesquisa por Telefone" class="texto-pesquisa">
    </form>


</div>

<table class="table table-hover">
    <tr>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Rotina de Pagamentos</th>

        <th width="120px;"></th>
    </tr>
    @forelse($empreendimentos as $empreendimento)
    <tr>
        <td>{{$empreendimento->nome}}</td>
        <td>{{$empreendimento->telefone}}</td>
        <td>{{$empreendimento->tipo_de_recebimento}}</td>


        <td>

            <a class="edit" onclick="edit('empreendimento/editar/{{$empreendimento->codigo}}')">
                <i class="fa fa-pencil-square-o"></i>
            </a>
             
            <a class="delete" onclick="del('empreendimento/deletar/{{$empreendimento->codigo}}')">
                <i class="fa fa-times"></i>
            </a>

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="500">Nenhum Estabelecimento Cadastrado!</td>
    </tr>

    @endforelse


</table>

<nav>
    {!!$empreendimentos->render()!!}
</nav>

<!-- Modal Para Deletar Algo -->
<div class="modal fade" id="modalConfirmacaoDeletar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-padrao5">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Deletar</h4>
            </div>
            <div class="modal-body">
                {!!Form::hidden('url-deletar', null, ['class' => 'url-deletar'])!!}
                <div class="preloader-deletar" style="display: none;">Deletando, por favor aguarde!!!</div>
                <p>Deseja realmente deletar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-confirmar-deletar">Deletar</button>
            </div>
        </div>
    </div>
</div>
<!-- Final do Modal de Deletar -->


<!-- Modal Para Gestão -->
<div class="modal fade" id="modalGestao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-padrao4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Gestão de Estabelecimentos</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
                <div class="alert alert-success msg-suc" role="alert" style="display: none">Salvo com Sucesso</div>

                <form class="form-padrao form-gestao" method="POST" action="painel/empreendimento/adicionar-empreendimento" send="painel/empreendimento/adicionar-empreendimento">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="nome" class="form-control" placeholder="Nome do Estabelecimento">
                    </div>
                    
                    <div class="form-group">
                        <input type="telefone" id="telefone" name="telefone"   placeholder="Insira o telefone" class="form-control" >
                    </div>
                  
                    <div class="form-group">
                        <input type="text" name="tipo_de_recebimento" class="form-control" placeholder="Rotina de Pagamento">
                    </div>




                    <div class="preloader" style="display: none">Enviando os dados, por favor aguarde...</div>

            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')    
    {!!HTML::script('assets/js/jquery.mask.js')!!}
<script>
            
            var urlAdd = 'empreendimento/adicionar-empreendimento';
</script>
@endsection