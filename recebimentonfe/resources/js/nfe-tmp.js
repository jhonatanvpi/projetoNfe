/////////////////////////////////////////////
// Cadastro AGÊNCIA                       ///
// FIN_AGENCIA 1.00                      ///   
// Desenvolvido por Matheus Jaschke     ///
// Março de 2016                        ///
// VPI GESTAO                          ///
/////////////////////////////////////////

$(document).ready(function() {
  
  getGrid();
  carregarEmpresa();
  carregarFilial();
  carregarBanco();
   
    

});


function novo(){
    $('#pesquisarModal').modal('show');
      
}
    
    
function carregarArquivoXml(){
    $('#selecionarArquivoXml').modal('show');
}


function selecionarXml(){
    
    var xml = new FormData();
    xml.append('anexo1', document.getElementById('arquivoXml').files[0]);       
    $.ajax({
            url: 'index.php?m=emissornfe&c=emissornfecontroller&f=salvarAnexoXml',
            type: 'POST',
            cache: false,
            data: xml,
            processData: false,
            contentType: false,
            async: false,
            
            success: function (enderecoAnexo) {

                    $.ajax({
                        url: 'index.php?m=emissornfe&c=emissornfecontroller&f=xmlParser',
                        data: {
                            enderecoAnexo: enderecoAnexo
                        },
                        type: 'POST',
                        dataType: 'json',
                        async: true,
                        success: function (r) {
                            alert(r);
                        
                        },
                        error: function (e) {
                            mensagem('Atenção', 'Erro ao salvar', 'error');

                        }

                    });
                }
                
            });
                
}   



function emitirNfe(){
     
     
     alert("inicio nfe");
   
    $.ajax({
        url: 'index.php?m=emissornfe&c=emissornfecontroller&f=emitirNfe',
        data: {
          
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {


        },
        error: function(e) {
            mensagem('Atenção', 'Erro ao salvar', 'error');

        }
    });
              
       
        
   
 
    
}

function excluir(){
    
    var agencia   =   $('#agencia').val();
    var idEmpresa =   $('#idEmpresa').val();             
    var idFilial  =   $('#idFilial').val();
    var idBanco   =   $('#idBanco').val();
     
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=excluir',
        data: {
            agencia: agencia,
            idEmpresa: idEmpresa,
            idFilial: idFilial,
            idBanco: idBanco
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {

            if (r == true) {
                mensagem('Sucesso', 'Excluído  com Sucesso', 'success');
                $('#basicModal').modal('hide');
                atualizar();
            }
            else {
                mensagem('Sucesso', 'Excluído  com Sucesso', 'success');
                $('#basicModal').modal('hide');
                atualizar();
            }
        },
        error: function(e) {
            mensagem('Sucesso', 'Excluído  com Sucesso', 'success');
            $('#basicModal').modal('hide');
            atualizar();
            

        }
    }); 
     
}


function pesquisar() {
    
   
    $('#pesquisarModal').modal('show');
    
    document.getElementById("idEmpresa").value          = 0;
    document.getElementById("idFilial").value           = 0;
    document.getElementById("idBanco").value            = 0;
    document.getElementById("agencia").value            = "";
    document.getElementById("nome").value               = "";
    document.getElementById("endereco").value           = "";
    document.getElementById("cep").value                = "";
    document.getElementById("cidade").value             = "";
    document.getElementById("bairro").value             = "";
    document.getElementById("telefone").value           = "";
    document.getElementById("nomeGerente").value        = "";
    document.getElementById("pessoaContato").value      = "";
    document.getElementById("email").value              = "";
    document.getElementById("observacao").value         = "";
    
     
}

function editar(){
        
    document.getElementById("idEmpresa").readOnly      = false;
    document.getElementById("idFilial").readOnly       = false;
    document.getElementById("idBanco").readOnly        = false;
    document.getElementById("agencia").readOnly        = false;
    document.getElementById("nome").readOnly           = false;
    document.getElementById("endereco").readOnly       = false;
    document.getElementById("cep").readOnly            = false;
    document.getElementById("cidade").readOnly         = false;
    document.getElementById("bairro").readOnly         = false;
    document.getElementById("telefone").readOnly       = false;
    document.getElementById("nomeGerente").readOnly    = false;
    document.getElementById("pessoaContato").readOnly  = false;
    document.getElementById("email").readOnly          = false;
    document.getElementById("observacao").readOnly     = false;
    
}

function buscaPrimeiroRegistro(){
    
    document.getElementById("idEmpresa").readOnly      = true;
    document.getElementById("idFilial").readOnly       = true;
    document.getElementById("idBanco").readOnly        = true;
    document.getElementById("agencia").readOnly        = true;
    document.getElementById("nome").readOnly           = true;
    document.getElementById("endereco").readOnly       = true;
    document.getElementById("cep").readOnly            = true;
    document.getElementById("cidade").readOnly         = true;
    document.getElementById("bairro").readOnly         = true;
    document.getElementById("telefone").readOnly       = true;
    document.getElementById("nomeGerente").readOnly    = true;
    document.getElementById("pessoaContato").readOnly  = true;
    document.getElementById("email").readOnly          = true;
    document.getElementById("observacao").readOnly     = true;
   
   
   
    
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=buscaPrimeiroRegistro',
        data: {
       
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
            document.getElementById("idEmpresa").value     = r[0];
            document.getElementById("idFilial").value      = r[1];
            document.getElementById("idBanco").value       = r[2];
            document.getElementById("agencia").value       = r[3];
            document.getElementById("nome").value          = r[4];
            document.getElementById("endereco").value      = r[5];
            document.getElementById("cep").value           = r[6];
            document.getElementById("cidade").value        = r[7];
            document.getElementById("bairro").value        = r[8];
            document.getElementById("telefone").value      = r[9];  
            document.getElementById("nomeGerente").value   = r[10];
            document.getElementById("pessoaContato").value = r[11];
            document.getElementById("email").value         = r[12];
            document.getElementById("observacao").value    = r[13];
       
        },
        error: function(e) {

        }
    }); 
 
    
}
function buscaRegistroAnterior(){
    
    document.getElementById("idEmpresa").readOnly      = true;
    document.getElementById("idFilial").readOnly       = true;
    document.getElementById("idBanco").readOnly        = true;
    document.getElementById("agencia").readOnly        = true;
    document.getElementById("nome").readOnly           = true;
    document.getElementById("endereco").readOnly       = true;
    document.getElementById("cep").readOnly            = true;
    document.getElementById("cidade").readOnly         = true;
    document.getElementById("bairro").readOnly         = true;
    document.getElementById("telefone").readOnly       = true;
    document.getElementById("nomeGerente").readOnly    = true;
    document.getElementById("pessoaContato").readOnly  = true;
    document.getElementById("email").readOnly          = true;
    document.getElementById("observacao").readOnly     = true;
   
    
    
    var agencia    =   $('#agencia').val();
    var idEmpresa  =   $('#idEmpresa').val();             
    var idFilial   =   $('#idFilial').val();
    var idBanco    =   $('#idBanco').val();
    
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=buscaRegistroAnterior',
        data: {
            agencia: agencia,
            idEmpresa: idEmpresa,
            idFilial: idFilial,
            idBanco: idBanco
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
            
            if(r != false){
                document.getElementById("idEmpresa").value     = r[0];
                document.getElementById("idFilial").value      = r[1];
                document.getElementById("idBanco").value       = r[2];
                document.getElementById("agencia").value       = r[3];
                document.getElementById("nome").value          = r[4];
                document.getElementById("endereco").value      = r[5];
                document.getElementById("cep").value           = r[6];
                document.getElementById("cidade").value        = r[7];
                document.getElementById("bairro").value        = r[8];
                document.getElementById("telefone").value      = r[9];  
                document.getElementById("nomeGerente").value   = r[10];
                document.getElementById("pessoaContato").value = r[11];
                document.getElementById("email").value         = r[12];
                document.getElementById("observacao").value    = r[13]; 
                            
            }
            
        },
        error: function(e) {

        }
    }); 
 
    
}
function buscaRegistroProximo(){
    
    document.getElementById("idEmpresa").readOnly      = true;
    document.getElementById("idFilial").readOnly       = true;
    document.getElementById("idBanco").readOnly        = true;
    document.getElementById("agencia").readOnly        = true;
    document.getElementById("nome").readOnly           = true;
    document.getElementById("endereco").readOnly       = true;
    document.getElementById("cep").readOnly            = true;
    document.getElementById("cidade").readOnly         = true;
    document.getElementById("bairro").readOnly         = true;
    document.getElementById("telefone").readOnly       = true;
    document.getElementById("nomeGerente").readOnly    = true;
    document.getElementById("pessoaContato").readOnly  = true;
    document.getElementById("email").readOnly          = true;
    document.getElementById("observacao").readOnly     = true;
   
    
    var agencia    =   $('#agencia').val();
    var idEmpresa  =   $('#idEmpresa').val();             
    var idFilial   =   $('#idFilial').val();
    var idBanco    =   $('#idBanco').val();   
    
   
   
    
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=buscaRegistroProximo',
        data: {
            agencia: agencia,
            idEmpresa: idEmpresa,
            idFilial: idFilial,
            idBanco: idBanco
       
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
            
            if(r != false){
                
                document.getElementById("idEmpresa").value     = r[0];
                document.getElementById("idFilial").value      = r[1];
                document.getElementById("idBanco").value       = r[2];
                document.getElementById("agencia").value       = r[3];
                document.getElementById("nome").value          = r[4];
                document.getElementById("endereco").value      = r[5];
                document.getElementById("cep").value           = r[6];
                document.getElementById("cidade").value        = r[7];
                document.getElementById("bairro").value        = r[8];
                document.getElementById("telefone").value      = r[9];  
                document.getElementById("nomeGerente").value   = r[10];
                document.getElementById("pessoaContato").value = r[11];
                document.getElementById("email").value         = r[12];
                document.getElementById("observacao").value    = r[13];  
                      
            
            }
           
        },
        error: function(e) {

        }
    }); 
 
    
}


function buscaUltimoRegistro(){
    
    document.getElementById("idEmpresa").readOnly      = true;
    document.getElementById("idFilial").readOnly       = true;
    document.getElementById("idBanco").readOnly        = true;
    document.getElementById("agencia").readOnly        = true;
    document.getElementById("nome").readOnly           = true;
    document.getElementById("endereco").readOnly       = true;
    document.getElementById("cep").readOnly            = true;
    document.getElementById("cidade").readOnly         = true;
    document.getElementById("bairro").readOnly         = true;
    document.getElementById("telefone").readOnly       = true;
    document.getElementById("nomeGerente").readOnly    = true;
    document.getElementById("pessoaContato").readOnly  = true;
    document.getElementById("email").readOnly          = true;
    document.getElementById("observacao").readOnly     = true;
    
      
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=buscaUltimoRegistro',
        data: {
       
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
            
            document.getElementById("idEmpresa").value     = r[0];
            document.getElementById("idFilial").value      = r[1];
            document.getElementById("idBanco").value       = r[2];
            document.getElementById("agencia").value       = r[3];
            document.getElementById("nome").value          = r[4];
            document.getElementById("endereco").value      = r[5];
            document.getElementById("cep").value           = r[6];
            document.getElementById("cidade").value        = r[7];
            document.getElementById("bairro").value        = r[8];
            document.getElementById("telefone").value      = r[9];  
            document.getElementById("nomeGerente").value   = r[10];
            document.getElementById("pessoaContato").value = r[11];
            document.getElementById("email").value         = r[12];
            document.getElementById("observacao").value    = r[13];  
             
           
        },
        error: function(e) {

        }
    }); 

}

function pesquisaFiltro(){
    
    var idInicial   = document.getElementById("idPesquisarInicio").value;
    var idFinal     = document.getElementById("idPesquisarFim").value;
    var nomeInicial = document.getElementById("nomePesquisarInicio").value;
    var nomeFim     = document.getElementById("nomePesquisarFim").value;
    
    
    // Pesquisa Para alimentar campos
    
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=pesquisaSimples',
        data: {
            idInicial: idInicial,
            nomeInicial: nomeInicial
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
                        
            document.getElementById("idEmpresa").value     = r[0];
            document.getElementById("idFilial").value      = r[1];
            document.getElementById("idBanco").value       = r[2];
            document.getElementById("agencia").value       = r[3];
            document.getElementById("nome").value          = r[4];
            document.getElementById("endereco").value      = r[5];
            document.getElementById("cep").value           = r[6];
            document.getElementById("cidade").value        = r[7];
            document.getElementById("bairro").value        = r[8];
            document.getElementById("telefone").value      = r[9];  
            document.getElementById("nomeGerente").value   = r[10];
            document.getElementById("pessoaContato").value = r[11];
            document.getElementById("email").value         = r[12];
            document.getElementById("observacao").value    = r[13];     
                               
            $('#pesquisarModal').modal('hide');          
                    
                     
        },
        error: function(e) {

        }
    }); 
            
    
}
function getGrid() {
 
    $('#grid').DataTable({
        "destroy": true,
        ajax: {
            "url": "index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=getGrid",
              
            "type": "POST",
        },
         language: {
            "url": '//cdn.datatables.net/plug-ins/1.10.7/i18n/Portuguese-Brasil.json'
        },
        "columns": [
            {"data": "EMPRESA"},
            {"data": "FILIAL"},
            {"data": "BANCO"},
            {"data": "AGENCIA"},
            {"data": "NOME"},
            {"data": "ENDERECO"},
            {"data": "CIDADE"},
            {"data": "BAIRRO"},
            {"data": "TELEFONE"},
            {"data": "GERENTE"},
            {"data": "CONTATO"},
            {"data": "SELECIONAR"},
          
           
           
        ],
        searching: false
    });

    $('#grid')
            .removeClass('display')
            .addClass('table table-hover table-striped table-bordered');
    
     
 }
 
 function selecionaGrid(idBanco){
    
   
    // Pesquisa Para alimentar campos
    
    document.getElementById("idEmpresa").readOnly      = true;
    document.getElementById("idFilial").readOnly       = true;
    document.getElementById("idBanco").readOnly        = true;
    document.getElementById("agencia").readOnly        = true;
    document.getElementById("nome").readOnly           = true;
    document.getElementById("endereco").readOnly       = true;
    document.getElementById("cep").readOnly            = true;
    document.getElementById("cidade").readOnly         = true;
    document.getElementById("bairro").readOnly         = true;
    document.getElementById("telefone").readOnly       = true;
    document.getElementById("nomeGerente").readOnly    = true;
    document.getElementById("pessoaContato").readOnly  = true;
    document.getElementById("email").readOnly          = true;
    document.getElementById("observacao").readOnly     = true;
   
    
    
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=selecionaGrid',
        data: {
            idBanco: idBanco
            
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
                      
            document.getElementById("idEmpresa").value     = r[0];
            document.getElementById("idFilial").value      = r[1];
            document.getElementById("idBanco").value       = r[2];
            document.getElementById("agencia").value       = r[3];
            document.getElementById("nome").value          = r[4];
            document.getElementById("endereco").value      = r[5];
            document.getElementById("cep").value           = r[6];
            document.getElementById("cidade").value        = r[7];
            document.getElementById("bairro").value        = r[8];
            document.getElementById("telefone").value      = r[9];  
            document.getElementById("nomeGerente").value   = r[10];
            document.getElementById("pessoaContato").value = r[11];
            document.getElementById("email").value         = r[12];
            document.getElementById("observacao").value    = r[13];         
                     
        },
        error: function(e) {

        }
    }); 
            
    
}
function atualizar(){
     
    getGrid();
  
    document.getElementById("idEmpresa").value          = 0;
    document.getElementById("idFilial").value           = 0;
    document.getElementById("idBanco").value            = 0;
    document.getElementById("agencia").value            = "";
    document.getElementById("nome").value               = "";
    document.getElementById("endereco").value           = "";
    document.getElementById("cep").value                = "";
    document.getElementById("cidade").value             = "";
    document.getElementById("bairro").value             = "";
    document.getElementById("telefone").value           = "";
    document.getElementById("nomeGerente").value        = "";
    document.getElementById("pessoaContato").value      = "";
    document.getElementById("email").value              = "";
    document.getElementById("observacao").value         = "";
    
           
  
             
    
}

function carregarEmpresa(){
    
           
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=carregarEmpresa',
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
    
    var idEmpresa = document.getElementById("idEmpresa").value;
    
           
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=carregarFilial',
        data: {
            idEmpresa: idEmpresa
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        
        
        success: function(data) {
                
            if (data != false) {
                document.getElementById('idFilial').innerHTML = data;
               
            } else {
                mensagem('Atenção', 'Erro ao carregar a lista de  Filial', 'error'); 
               
            }

        },
        error: function() {
            desbloqueiaTela();
        }
    });
}

function carregarBanco(){
    
    var idEmpresa = document.getElementById("idEmpresa").value;
    var idFilial  = document.getElementById("idFilial").value;
           
    $.ajax({
        url: 'index.php?m=cadastroagencia&c=cadastroagenciacontroller&f=carregarBanco',
        data: {
            idEmpresa: idEmpresa,
            idFilial: idFilial
            
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        
        
        success: function(data) {
                
            if (data != false) {
                document.getElementById('idBanco').innerHTML = data;
               
            } else {
                mensagem('Atenção', 'Erro ao carregar a lista de  bancos', 'error'); 
               
            }

        },
        error: function() {
            desbloqueiaTela();
        }
    });
}






//////////////////////////////////////////////////////////////
//         FUNÇÕES EPECÍFICAS PARA ESSE BRD                //         
/////////////////////////////////////////////////////////////


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
function mascara(telefone1){ 
    if(telefone1.value.length == 0){
         telefone1.value = '(' + telefone1.value;
    }     
    if(telefone1.value.length == 3){
        telefone1.value = telefone1.value + ') ';
    }    
    if(telefone1.value.length == 9){
        telefone1.value = telefone1.value + '-'; 
    }
}

function mascaraCNPJ(cnpj){
    
    if(cnpj.value.length == 2){
      cnpj.value =  cnpj.value + '.';
    }  
    if(cnpj.value.length == 6){
      cnpj.value = cnpj.value + '.';
    }  
    if(cnpj.value.length == 10){
      cnpj.value = cnpj.value + '/';
    }  
    if(cnpj.value.length == 15){
      cnpj.value = cnpj.value + '-';
    }       
}

function mascaraCEP(cep){
    
    if(cep.value.length == 5){
      cep.value =  cep.value + '-';
    }  
    
}

