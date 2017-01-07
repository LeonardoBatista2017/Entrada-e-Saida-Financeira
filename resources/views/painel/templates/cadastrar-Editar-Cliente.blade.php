


@extends('painel.template.index')
@section('content')

		<nav class="navbar navbar-default ">
		  <div class="container-fluid">
		    
		    <div>
		      <ul class="nav navbar-nav ">

		        <li><a href="#">Home</a></li>
		        <li class="active"><a href="cadastrar">Cadastrar</a></li>
		        <li><a href="listarFuncionario">Listar</a></li>
		        
		      </ul>
		    </div>
		  </div>
		</nav>

		

		<div class="container">


				<h1>Cadastrar Cliente</h1>

				{{Form::open(array('url'=>'inserirCliente','class'=>'teste'))}}
					
					{{Form::text('nome','',array('placeholder'=>'Nome','class'=>'form-control'))}} <br /><br />
					{{Form::text('dataNascimento','',array('placeholder'=>'','class'=>'form-control'))}} <br /><br />
					{{Form::text('email','',array('placeholder'=>'Email','class'=>'form-control'))}} <br /><br />
					{{Form::text('identidade','',array('placeholder'=>'Identidade','class'=>'form-control'))}} <br /><br />
					{{Form::text('cpf','',array('placeholder'=>'CPF','class'=>'form-control'))}} <br /><br />
					{{Form::text('pis','',array('placeholder'=>'PIS','class'=>'form-control'))}} <br /><br />
					{{Form::text('ctps','',array('placeholder'=>'CTPS','class'=>'form-control'))}} <br />
					{{Form::submit('Cadastrar',array('class'=>'btn btn-warning'))}}


					
				{{Form::close()}}
		</div>
@stop
