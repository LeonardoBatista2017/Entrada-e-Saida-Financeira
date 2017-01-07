
$(document).ready(function () {
    modalExcluiUsuario();
    modalExcluiLoja();
    modalExcluiAssistenciaTecnica();
    retornarButton();
    buscaUsuarioTranferenciaGarantia();
    exibirMensagemErro();
    validacaoCampo();
    camposObrigatorios();
});


function modalExcluiUsuario() {
    var urlExcluir = $('.jq-url-site').val();
    var btnExcluir = $('.jq-excluir-usuario');
    var btnConfirmaExclusao = $('.jq-confirma-exclusao');

    btnExcluir.each(function () {
        $(this).click(function () {

            var sPagina = $(this).data('pagina');
            var scodigoExclusao = $(this).data('codigo-excluir');
            btnConfirmaExclusao.prop('href', urlExcluir + '/exclui-usuario/' + sPagina + '/' + scodigoExclusao);
        });
    });
}

function modalExcluiLoja() {
    var urlExcluir = $('.jq-url-site').val();
    var btnExcluir = $('.jq-excluir-loja');
    var btnConfirmaExclusao = $('.jq-confirma-exclusao');

    btnExcluir.each(function () {
        $(this).click(function () {

            var sPagina = $(this).data('pagina');
            var scodigoExclusao = $(this).data('codigo-excluir');
            btnConfirmaExclusao.prop('href', urlExcluir + '/exclui-loja/' + sPagina + '/' + scodigoExclusao);
        });
    });

}

//inserido modal excluir assistencia tecnica - 09-05-2016
function modalExcluiAssistenciaTecnica() {
    var urlExcluir = $('.jq-url-site').val();
    var btnExcluir = $('.jq-excluir-assistencia-tecnica');
    var btnConfirmaExclusao = $('.jq-confirma-exclusao');

    btnExcluir.each(function () {
        $(this).click(function () {

            var sPagina = $(this).data('pagina');
            var scodigoExclusao = $(this).data('codigo-excluir');
            btnConfirmaExclusao.prop('href', urlExcluir + '/exclui-assistencia-tecnica/' + sPagina + '/' + scodigoExclusao);
        });
    });
}

function retornarButton() {
    $('.botao-voltar').click(function(){
            parent.history.back();
            return false;
        });

}


//funções para realizar a transferência de garantia

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    
}

function drop(ev) {

    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));

    var divTranferenciaItem = $('.div-item-transferencia');

     divTranferenciaItem.append('<input type="hidden" value="'+data+'" name="codigo_nota_fiscal[]" class="jq-item-novo"/>');
    
}


function buscaUsuarioTranferenciaGarantia(){

    var sEmail =$('.jq-email-proprietario-novo');

     var sNome = $('.jq-nome-proprietario-novo');
     var sCPF  = $('.jq-cpf-proprietario-novo');

     var sCodigoProprietarioNovo  = $('.jq-codigo-usuario-novo');

     var url = $('.jq-url-site').val();


     sEmail.keyup(function(){
          
        var url_get = url+'/busca-usuario-tranferencia/'+ sEmail.val();

        if(sEmail.val().length!=0){ 
            $.get(url_get, function(data, status){

                    if(data.nome!=null){
                         sNome.val(data.nome);
                         sCPF.val(data.cpf);
                         sCodigoProprietarioNovo.val(data.codigo);
                    }else{
                         sNome.val('');
                         sCPF.val('');
                         sCodigoProprietarioNovo.val('');
                    }   
            });
        }else{
                         sNome.val('');
                         sCPF.val('');
                         sCodigoProprietarioNovo.val('');
        } 
    });


    

}

function exibirMensagemErro(){

    var sMensagemErro =$('.jq-msg-erro').val();

    if(sMensagemErro=="* E-mail ou senha incorretos"){
        alert(sMensagemErro);
    }

}  

function validacaoCampo(){

    $('.jq-telefone').mask("(99)99999-9999");
    $('.jq-cpf').mask("999.999.999-99"); 
    $('.jq-rg').mask("99.999.999-9");

    $('.jq-numero').mask("9999");

    $('.jq-cnpj').mask("999999999999999");  


}  


function camposObrigatorios(){

    
    var oCamposObrigatorios = $(".jq-campo-obrigatorio");
    var oFormCadastro       = $("#jq-form-cadastro-edita");
       
    
    oCamposObrigatorios.blur(function(){
    
        var oCampoAtual = $(this);
        var oValorAtual = oCampoAtual.val();
    
        if (!oValorAtual) {
            oCampoAtual.addClass('estilo-campo-erro');
            oCampoAtual.closest(".form-group").addClass('has-error');
                        
        }else {
            oCampoAtual.removeClass('estilo-campo-erro');
            oCampoAtual.closest(".form-group").removeClass('has-error');
                        
        }
    
    
    });

    oFormCadastro.on('submit',function(){
    
        var bValido = true;
    
        oCamposObrigatorios.each(function() {
            
            var oCampoAtual = $(this);
            var oValorAtual = oCampoAtual.val();
            
            if (!oValorAtual) {
                oCampoAtual.addClass('estilo-campo-erro');
                oCampoAtual.closest(".form-group").addClass('has-error');
                bValido = false;
            }
            
        });
        
        if (!bValido) {
            return false;
            
        }else{  
            return true;
        }
    });
    
}