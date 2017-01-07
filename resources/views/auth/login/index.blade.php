@extends('auth.templates.index')


@section('form')
<form class="form-padrao form" method="POST" action="login">
    <div class="alert alert-danger" role="alert" style="display: none">Login Inválido</div>
    {!! csrf_field() !!}
    
    <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Usuário">
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Senha">
    </div>
    <a href="" class="recuperar-senha" data-toggle="modal" data-target="#recuperarSenha">Esqueceu a Senha?</a>

    <input type="submit" name="btn-enviar" value="Entrar" class="btn-padrao btn-enviar">
</form>
@endsection


@section('scripts')
<script>
    $(function(){
        jQuery('form.form').submit(function(){
            jQuery(".alert-danger").hide();
            
            //alert("formulário foi submetido");
            var dadosForm=jQuery(this).serialize();
            jQuery.ajax({
                url:"login",
                type:"POST",
                data:dadosForm,
                beforeSend:iniciaPreloader()
            }).done(function(data){
                finalizaPreloader();
                if(data==1){
                    location.href="painel";
            
                }else{
                    jQuery(".alert-danger").show();
                }
            }).fail(function(){
                finalizaPreloader();
                alert("falha ao enviar dados");
            });
            return false;
        });
    });
    
    function iniciaPreloader(){
        jQuery(".btn-enviar").attr("disabled");
        
    }
    function finalizaPreloader(){
        jQuery(".btn-enviar").removeAttr("disabled");
    }
</script>

@endsection

