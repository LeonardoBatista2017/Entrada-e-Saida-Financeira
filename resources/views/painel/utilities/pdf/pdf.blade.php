
<!DOCTYPE html>
<head>
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
<body>

    <table class="table table-bordered">

        <tr>
            <th>Estabelecimento</th>
            <th>Data:</th>

            <th>Valor</th>

        </tr>




        
      
        @forelse($entradas as $entrada)

       
        
          @forelse($entrada->empreendimentos as $empreendimento)
        <tr>
        
            <th>{{$empreendimento->nome}}</th> <td><?php echo date('d/m/Y', strtotime($entrada->data_da_entrada)); ?></td> <td>   </td>
           
        </tr>
        
        <tr>
            <th>Entrada</th> <td></td> <td>  {{$entrada->valor_entrada}} </td>

        </tr>
           @empty
          @endforelse
          
        @forelse($entrada->saidas as $saida)

        <tr>

            <th class="danger">Saida</th>  <td class="danger">{{$saida->nome_valor_saida}}</td>
            <td class="danger">-{{$saida->valor_saida}}</td>
        </tr>
       
        
        @empty
        <p>Nenhuma saida para o empreedimento <b></b> </p>
        @endforelse
        <tr>
            <th class="success">Lucro</th>
            <td class="success"></td>
            <td class="success"></td>

        </tr>
       
          @empty
        <p>Nenhuma entrada para o empreedimento <b></b> </p>
        @endforelse

            
       













    </table>




</body>
