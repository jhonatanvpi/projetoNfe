/*
 
    Emissão Nota Fiscal                    
    Projeto VPIGESTAO                               
    Desenvolvido por Jhonatan Da Silva     
    Agosto de 2017                          
    VPI TECNOLOGIA                          

*/

$(document).ready(function() {
    
    esconderAbas();
    carregarEmpresa(); 
    reqCEP();
    
    document.getElementById('horaSaida').value   = getTime();
    document.getElementById('horaEmissao').value = getTime();
    document.getElementById('dataEmissao').value = getDate();
    $('#dataSaida').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR"
    }); 
    $('#dataEmissao').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR"
    }); 
    
});

function esconderAbas(){
    
    $("div.contaba").hide();
    // mostra somente  a primeira aba
    $("div.contaba:first").show();
    // seta a primeira aba como selecionada (na lista de abas)
    $("#abas a:first").addClass("selected");

    // quando clicar no link de uma aba
    $("#abas a").click(function(){
        // oculta todas as abas
        $("div.contaba").hide();
        // tira a seleção da aba atual
        $("#abas a").removeClass("selected");

        // adiciona a classe selected na selecionada atualmente
        $(this).addClass("selected");
        // mostra a aba clicada
        $($(this).attr("href")).show();
        // pra nao ir para o link
        return false; 
    });
}

function reqCEP(){
   /* Executa a requisição quando o campo CEP perder o foco */
   $('#cep').blur(function(){
            /* Configura a requisição AJAX */
           $.ajax({
                url : 'index.php?m=emitirnfe&c=emitirnfecontroller&f=consultarCep', /* URL que será chamada */ 
                type : 'POST', /* Tipo da requisição */ 
                data: 'cep=' + $('#cep').val(), /* dado que será enviado via POST */
                dataType: 'json', /* Tipo de transmissão */
                success: function(data){
                    
                    if(data.sucesso == 1){
                        $('#endereco').val(data.endereco);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.cidade);
                        $('#estado').val(data.estado);
 
                        $('#numero').focus();
                    }
                    else {
                        mensagem('Atenção', 'CEP Não encontrado', 'error');
                    }
                }
           });   
   return false;    
   });
}

function getTime(){
    
    var date = new Date(),
        hora = date.getHours(),
        min  = date.getMinutes();

        if(min.toString().length <= 1){
            min = "0" + min;
        }
    var hr   = hora + ":" + min;

    return hr;
}


function getDate(){
    
    var date = new Date(),
        month = '';
    month = date.getUTCMonth().toString();
    if(month[0] == "0" || 
       month[0] ==  0 ||
       month.length <= 1){
        month = "0" + (parseInt(month) + 1).toString();
    }
    else{
        month = date.getUTCMonth();
    }
    date = [date.getDate(),month,date.getUTCFullYear()];
    var data = date.join('/');
    
    return data;
}


function novaNFE(){
    
    document.getElementById("idFuncionario").readOnly             = true;
    
    document.getElementById("setor").value            = 0;
    
    $('#desativado').prop('checked', false);
    
    $('#valeTransporte').prop('checked', false);
    
    document.getElementById("dataDemissao").value            = "";
    
    document.getElementById("imagemView").innerHTML = "";
         
    $.ajax({
        url: 'index.php?m=emitirnfe&c=emitirnfecontroller&f=novaNFE',
        data: {
            
           
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
            
             document.getElementById("idFuncionario").value  = r;
             carregarDataAtual();    
            
        },
        error: function(e) {
           
        }
    }); 
    
}
    

///////////////////////////////////////////////////
///     Funções específicas para esse ERP        //
///                                             //
//////////////////////////////////////////////////


function carregarEmpresa(){
    
    $.ajax({
        url: 'index.php?m=emitirnfe&c=emitirnfecontroller&f=carregarEmpresa',
        data: {
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        
        success: function(data) {
                
            if (data != false) {
                document.getElementById('idEmpresa').innerHTML = data;
            } else {
                mensagem('Atenção', 'Erro ao carregar a lista de  EMPRESA', 'error'); 
            }
        },
        error: function() {
            desbloqueiaTela();
        }
    });
}


function carregarFilial(){
    
    var idEmpresa                 =   $('#idEmpresa').val(); 
           
    $.ajax({
        url: 'index.php?m=emitirnfe&c=emitirnfecontroller&f=carregarFilial',
        data: {
            idEmpresa: idEmpresa
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        
        success: function(data) {
                
            if (data != false) {
                document.getElementById('empresaFilial').innerHTML = data;
               
            } else {
                alert('Erro ao carregar a lista de FILIAL');
            }

        },
        error: function() {
            desbloqueiaTela();
        }
    });
 }

function carregarFuncao(){
    
           
    $.ajax({
        url: 'index.php?m=emitirnfe&c=emitirnfecontroller&f=carregarFuncao',
        data: {
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        
        
        success: function(data) {
                
            if (data != false) {
                document.getElementById('funcao').innerHTML = data;
               
            } else {
                mensagem('Atenção', 'Erro ao carregar a lista de Funções', 'error'); 
               
            }

        },
        error: function() {
            desbloqueiaTela();
        }
    });
}

function carregarSetor(){
    
           
    $.ajax({
        url: 'index.php?m=emitirnfe&c=emitirnfecontroller&f=carregarSetor',
        data: {
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        
        
        success: function(data) {
                
            if (data != false) {
                document.getElementById('setor').innerHTML = data;
               
            } else {
                mensagem('Atenção', 'Erro ao carregar a lista de Setores', 'error'); 
               
            }

        },
        error: function() {
            desbloqueiaTela();
        }
    });
}

function carregarDataAtual() {


    $.ajax({
        url: 'index.php?m=emitirnfe&c=emitirnfecontroller&f=carregarDataAtual',
        data: {
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function (data) {

            document.getElementById('dataCadastro').value = data;


        },
        error: function () {

        }
    });


}









function selecionarTipo(){
   
    var tipo = document.getElementById("tipoFilial").value;
   
    tipoFilial = tipo;
     
        
    if(tipoFilial == 1){
       document.getElementById("codigoCNPJ").readOnly  = true;       
       document.getElementById("codigoCEI").readOnly = false;               
    }
    else{      
       document.getElementById("codigoCEI").readOnly  = true;
       document.getElementById("codigoCNPJ").readOnly   = false;
   }
    
}

function validarCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
   
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}
function mascaraTelefone(telefone1){ 
    if(telefone1.value.length == 0){
         telefone1.value = '(' + telefone1.value;
    }     
    if(telefone1.value.length == 3){
        telefone1.value = telefone1.value + ') ';
    }
     
   
}



function mascaraCPF(cpf){
    
    if(cpf.value.length == 3){
      cpf.value =  cpf.value + '.';
    }  
    if(cpf.value.length == 7){
      cpf.value = cpf.value + '.';
    }  
    if(cpf.value.length == 11){
      cpf.value = cpf.value + '-';
    }  
           
}

function mascaraCEP(cep){
    
    if(cep.value.length == 5){
      cep.value =  cep.value + '-';
    }  
    
}

function mascaraCEI(cnpj){
    
    if(cnpj.value.length == 2){
      cnpj.value =  cnpj.value + '.';
    }  
    if(cnpj.value.length == 6){
      cnpj.value = cnpj.value + '.';
    }  
    if(cnpj.value.length == 11){
      cnpj.value = cnpj.value + '/';
    }  
    
}

/* Máscaras Horario */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mvalor(v){
    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
    v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
    v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
	
    v=v.replace(/(\d)(\d{2})$/,"$1:$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}


/* Máscaras ER */
function mascaraValor(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascaraValor()", 1)
}
function execmascaraValor() {
    v_obj.value = v_fun(v_obj.value)
}
function mvalorValor(valor) {
    valor = valor.replace(/\D/g, "");//Remove tudo o que não é dígito
    valor = valor.replace(/(\d)(\d{8})$/, "$1.$2");//coloca o ponto dos milhões
    valor = valor.replace(/(\d)(\d{5})$/, "$1.$2");//coloca o ponto dos milhares

    valor = valor.replace(/(\d)(\d{2})$/, "$1,$2");//coloca a virgula antes dos 2 últimos dígitos
    return valor;
}



/// CARREGAMENTO DE IMAGEM EM TELA, APOS SALVA


function carregarImagem( img ){
    
    var caminho = img.substr(51);
    
    
    carregar = new Image();
    carregar.src = "/gestaopessoas/fwk/uploads/imagens/" + caminho;
    
    document.getElementById("imagemView").innerHTML = "Carregando...";
    setTimeout( "verificaCarregamento()", 1 );
}
 



function verificaCarregamento(){
    
    if( carregar.complete )
    {
        document.getElementById("imagemView").innerHTML = "<img src=\"" 
                + carregar.src + " \" style='max-width:150px; padding-top: 1px; padding-right: 1px; max-height:140px; background_color: #000000;' onclick='abrirImagem()' />";
    }
    else
    {
        setTimeout( "verificaCarregamento()", 1 );
    }
}


function habilitarDataDemissao(){
    
    if ($('#desativado').is(':checked') == true) {
    
         document.getElementById("dataDemissao").disabled = false;
        
    }else{
        
        document.getElementById("dataDemissao").value = "";
        document.getElementById("dataDemissao").disabled = true; 
        document.getElementById("desativado").checked = false; 
        
    }
    
    
    
}