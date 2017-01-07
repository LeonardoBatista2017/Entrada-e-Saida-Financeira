@extends('painel.templates.index')

@section('content')

<a href="{{url('/painel/alunos')}}">
    <i class="fa fa-angle-double-left"></i> Voltar Para a Listagem dos Aluno
</a>

<h1 class="titulo-pg-painel">Listagem  dos Pais do Aluno: <b>{{$aluno->nome}}</b> ({{$pais->count()}}):</h1>

<div class="divider"></div>

<div class="col-md-12">
    <form class="form-padrao form-inline padding-20 form-pesquisa" method="POST" send="/painel/alunos/pesquisar-pais/{{$id}}/">
        <a href="" class="btn-cadastrar" data-toggle="modal" data-target="#modalGestao"><i class="fa fa-plus-circle"></i> Cadastrar</a>
        <input type="text" placeholder="Pesquisa" class="texto-pesquisa">
    </form>
    
    @if( isset($palavraPesquisa) )
        <p>Resultados para a pesquisa <b>{{$palavraPesquisa}}</b></p>
    @endif
</div>

<table class="table table-hover">
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th width="70px;"></th>
    </tr>
    @forelse($pais as $pai)
    <tr>
        <td>{{$pai->nome}}</td>
        <td>{{$pai->email}}</td>
        <td>
            <a class="delete" onclick="del('/painel/alunos/deletar-pai/{{$id}}/{{$pai->id}}')">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="500">Nenhum Pai Cadastrado!</td>
    </tr>
    @endforelse
</table>

<nav>
    {!!$pais->render()!!}
</nav>




<!-- Modal Para GestÃ£o -->
<div class="modal fade" id="modalGestao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-padrao4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Novo Pai</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning msg-war" role="alert" style="display: none"></div>
                <div class="alert alert-success msg-suc" role="alert" style="display: none"></div>

                <form class="form-padrao form-gestao" action="/painel/alunos/adicionar-pai/{{$id}}" send="/painel/alunos/adicionar-pai/{{$id}}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        {!!Form::select('id_pai[]', $paisAdd, null, ['class' => 'form-control', 'multiple'])!!}
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

@endsection