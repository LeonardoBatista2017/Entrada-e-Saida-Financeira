<?php






Route::get('email', function(){
	
	Mail::raw('Mensagem de testo puro', function ($m) {
    	 $m->to('querotestar.isso@yahoo.com.br','João')->subject('Enviando E-mails pelo Laravel');
	});
});

Route::group(['prefix'=>'painel','middleware' => 'auth'], function(){
  
      Route::get('pdf','Painel\UtilitiesController@pdf');
      Route::controller('movimentacao', 'Painel\MovimentacaoController');
      Route::controller('saida2','Painel\SaidaController');
      Route::controller('saida/{codigo}','Painel\SaidaController');
      Route::controller('empreendimento','Painel\EmpreendimentoController');
      Route::controller('entrada','Painel\EntradaController');
      Route::controller('/','Painel\PainelController');
     
 
});


// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('recuperar-senha/email', 'Auth\PasswordController@getEmail');
Route::post('recuperar-senha/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('resetar-senha/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('resetar-senha/reset', 'Auth\PasswordController@postReset');


