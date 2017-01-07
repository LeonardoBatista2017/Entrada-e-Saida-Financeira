<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>{{$titulo or 'Painel | Cadastrado Cliente - Thyca'}}</title>

        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="{{url('')}}">-->
        {!!HTML::style('assets/css/bootstrap.min.css')!!}
        <!-- Optional theme -->
        {!!HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css')!!}
        <!--<link rel="stylesheet" href="">-->
        {!!HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')!!}
        {!!HTML::style('assets/painel/css/especializati.css')!!}
        {!!HTML::style('assets/painel/css/especializati-responsivo.css')!!}

        {!!HTML::script('assets/js/jquery-2.1.4.min.js')!!}

    </head>
    <body class="bg-padrao">

        <header>
            <h1 class="oculta">Painel | EspecializaTi</h1>
        </header>

        <section class="painel">
            <h1 class="oculta">{{$titulo or 'Painel | Cadastro Cliente - Thyca'}}</h1>

            <div class="topo-painel col-md-12">
                <a href="" class="icon-acoes-painel">
                    <i class="fa fa-expand"></i>
                </a>

                        <!--<img src="imgs/" class="logo-painel" alt="Logo EspecializaTi" title="Painel EspecializaTi">-->
               {!!HTML::image('assets/imgs/logo.jpg', 'Thyca', ['class' => 'logo-painel', 'title' => 'Thyca - Cadastro Cliente'])!!}
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
                <div class="cont">
                    @yield('content')
                </div>
            </section>
            <!--End ConteÃºdo-->
        </section>

    
        <!-- Latest compiled and minified JavaScript -->
        {!!HTML::script('assets/js/bootstrap.min.js')!!}
         {!!HTML::script('assets/js/jquery.mask.js')!!}
         
       
         
    </body>
</html>