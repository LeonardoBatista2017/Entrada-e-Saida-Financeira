
@extends('auth.templates.index')

<!-- resources/views/auth/password.blade.php -->
@section('form2')


<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-padrao2">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Recuperar Senha</h4>
        </div>
        <div class="modal-body">
            <form class="form-padrao"  method="POST" action="/recuperar-senha/email">
                 {!! csrf_field() !!}
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="E-mail" value="{{ old('email') }}">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary">Recuperar</button>
        </div>
    </div>
</div>
@endsection

