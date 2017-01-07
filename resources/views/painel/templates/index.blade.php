<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>{{$titulo or 'Giulio´s Interprise'}}</title>

        <!-- Latest compiled and minified CSS -->

        {!!HTML::style('assets/css/bootstrap.min.css')!!}

        <!-- Optional theme -->
        {!!HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css')!!}
        {!!HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')!!}
        {!!HTML::style('assets/painel/css/especializati.css')!!}
        {!!HTML::style('assets/painel/css/especializati-responsivo.css')!!}


        <!--JQuery-->
        {!!HTML::script('assets/js/jquery-2.1.4.min.js')!!}
    </head>
    
    <body class="bg-padrao">

        <header>
            <h1 class="oculta">Painel | EspecializaTi</h1>
        </header>

        <section class="painel">
            <h1 class="oculta">Painel | EspecializaTi</h1>

            <div class="topo-painel col-md-12">
                <a href="" class="icon-acoes-painel">
                    <i class="fa fa-expand"></i>
                </a>


               {!!HTML::image('assets/imgs/logo_1.png','Thyca',['class'=>'logo-painel','title'=>'Painel Thyca'])!!}

                <select class="acoes-painel">
                    <option value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
                    <option value="sair" class="sair">Sair</option>
                </select>
            </div>
            <!--End Top-->

            <div class="clear"></div>


            <!--open menu-->
            @include('painel.includes.menu')
            <!--End menu-->


            <section class="conteudo col-md-10">
                @yield('content')
            </section>
            <!--End ConteÃºdo-->
        </section>
        
        
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
        

        

        <!-- Latest compiled and minified JavaScript -->
        {!!HTML::script('assets/js/bootstrap.min.js')!!}
       
         {!!HTML::script('assets/js/geral.js')!!}
         
        @yield('scripts')
         
          
         <script>
              
              $(function(){
                  
                   
                      
               jQuery("form.form-gestao").submit(function(){
                   jQuery(".msg-war").hide();
                   jQuery(".msg-suc").hide();
                   
                   var dadosForm = jQuery(this).serialize();
                   
                   jQuery.ajax({
                       url: jQuery(this).attr("send"),
                       data: dadosForm,
                       type: "POST",
                       beforeSend: iniciaPreloader()
                   }).done(function(data){
                       finalizaPreloader();
                       
                       if( data === "1" ){
                           jQuery(".msg-suc").html("Sucesso ao Salvar!");
                           jQuery(".msg-suc").show();
                           
                           setTimeout("jQuery('.msg-suc').hide();jQuery('#modalGestao').modal('hide');location.reload();", 4500);
                       }else{
                           jQuery(".msg-war").html(data);
                           jQuery(".msg-war").show();
                           
                           setTimeout("jQuery('.msg-war').hide();", 4500);
                       }
                   }).fail(function(){
                       finalizaPreloader();
                       alert("Falha Inesperada!");
                   });
                   
                   return false;
               });
       
            });
           
           function iniciaPreloader(){
               jQuery(".preloader").show();
           }
           function finalizaPreloader(){
               jQuery(".preloader").hide();
           }
          
              
          function edit(url){
               jQuery.getJSON(url, function(data){
                   jQuery.each(data, function(key, val){
                       jQuery("input[name='"+key+"']").attr("value", val);
                       
                       if( jQuery("option[value='"+val+"']").val() == val ){
                           jQuery("option[value='"+val+"']").attr("selected", true);
                       }
                   });
               });
               
               jQuery("#modalGestao").modal();
               
               jQuery("form.form-gestao").attr("send", url);
               jQuery("form.form-gestao").attr("action", url);
               
    }
    
   
      function del(url){
               jQuery(".url-deletar").val(url);
               
               jQuery("#modalConfirmacaoDeletar").modal();
           }
           
           jQuery(".btn-confirmar-deletar").click(function(){
               var url = jQuery(".url-deletar").val();
               
               
               jQuery.ajax({
                   url: url,
                   type: "GET",
                   beforeSend: inicializaPreloaderDeletar()
               }).done(function(data){
                   finalizaPreloaderDeletar();
                   
                   if( data == "1" ){
                        location.reload();
                    }else{
                        alert("Falha ao deletar");
                    }
               }).fail(function(){
                   finalizaPreloaderDeletar();
                   alert("Falha ao enviar dados!");
               });
           });
           
           function inicializaPreloaderDeletar(){
               jQuery(".preloader-deletar").show();
           }
           function finalizaPreloaderDeletar(){
               jQuery(".preloader-deletar").hide();
           }
            jQuery("form.form-pesquisa").submit(function(){
               var textoPesquisa = jQuery(".texto-pesquisa").val();
               var url = jQuery(this).attr("send");
               
               location.href = url+textoPesquisa;
               
               return false;
           });
           
           
           jQuery(".acoes-painel").change(function(){
               if( jQuery(this).val() == "sair" )
               {
                   location.href = "{{url('/logout')}}";
               }
           });
           
           
           jQuery(".btn-cadastrar").click(function(){
               jQuery("form.form-gestao").attr("send", urlAdd);
               jQuery("form.form-gestao").attr("action", urlAdd);
               
               /*
                jQuery("form.form-gestao").each(function(){
                   this.reset;
               });
               * 
                */
               jQuery(":input[type='text']").attr("value", "");
               
                jQuery("#telefone").mask("(00)00000-0000");
                jQuery("#data_da_entrada").mask("00/00/0000");
           });
         </script>

        
    </body>
</html>
