/////////////////////////////////////////////
// Cadastro AGÊNCIA                       ///
// FIN_AGENCIA 1.00                      ///   
// Desenvolvido por Matheus Jaschke     ///
// Março de 2016                        ///
// VPI GESTAO                          ///
/////////////////////////////////////////

$(document).ready(function() {
  
  getGrid();
  carregarEmpresas();
  //carregarEmpresa();
  //carregarFilial();
  
  $('#dataInicial').datepicker({
    format: "dd/mm/yyyy",
    language: "pt-BR"
  });
  $('#dataFinal').datepicker({
    format: "dd/mm/yyyy",
    language: "pt-BR"
  });
});


function mostrarModalPesquisa(){
    $('#filtroNFE').modal('show');
}



function novo(){
    
    $('#pesquisarModal').modal('show');
}
    
    
function carregarArquivoXml(){
    $('#selecionarArquivoXml').modal('show');
}


function lidarComVariosArquivos(){
    
    var files = document.getElementById('arquivoXml').files;
    var fileSize = files.length;
    for(var i = 0; i < fileSize; i++){
        selecionarXml(files[i]);
    }
}


function selecionarXml(file,cont){
    var xml = new FormData();
    xml.append('anexo1',file);
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
                            
                            mensagem('Sucesso', 'NFE salva', 'success');
                            getGrid();
                            carregarEmpresas();
                            $('#selecionarArquivoXml').modal('hide');
                        },
                        error: function (e) {
                            mensagem('Atenção', 'Erro ao salvar', 'error');
                            getGrid();
                        }

                    });
                }
                
            });
                
}   


function carregarEmpresas() {

    $.ajax({
        url: 'index.php?m=emissornfe&c=emissornfecontroller&f=carregarEmpresas',
        data: {
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function (data) {

            if (data != false) {
                document.getElementById('CNPJFiltro').innerHTML = data;

            } else {
                mensagem('Atenção', 'Erro ao carregar a lista de Funcionarios', 'error');

            }

        },
        error: function () {
            desbloqueiaTela();
        }
    });
}


function emitirNfe(){
     
   
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


function getGrid() {
    
    var dataInicial = $('#dataInicial').val(),
        dataFinal = $('#dataFinal').val(),
        destCNPJ = $('#CNPJFiltro').val();

    var objFiltro = new Object();
    objFiltro.CNPJFiltro = document.getElementById("CNPJFiltro").value;
    objFiltro.dataInicialFiltro = document.getElementById("dataInicial").value;
    objFiltro.dataFinalFiltro = document.getElementById("dataFinal").value;
    tableGrid = $('#grid').DataTable({
        "destroy":true,
        ajax: {
            "url": "index.php?m=emissornfe&c=emissornfecontroller&f=getGrid",
            "data": objFiltro,
            "type": "POST"
        },
        language: {
            "url": '//cdn.datatables.net/plug-ins/1.10.7/i18n/Portuguese-Brasil.json'
        },
        "columns": [
            {"data": "IDE_NATOP"},
            {"data": "DEST_XNOME"},
            {"data": "DEST_CNPJ"},
            {"data": "DEST_XLGR"},
            {"data": "DEST_NRO"},
            {"data": "DEST_XBAIRRO"},
            {"data": "DEST_FONE"},
            {"data": "SELECIONAR"}
        ],
        searching: false
    });

    $('#grid')
            .removeClass('display')
            .addClass('table table-hover table-striped table-bordered');
    
    $('#filtroNFE').modal('hide');
 }
 
 
function atualizarGrid(){
    setTimeout(function(){tableGrid.ajax.reload();}, 200);
}


function selecionaGrid(ID,destCNPJ){
    
    document.getElementById("cUF").readOnly = true;
    document.getElementById("cNF").readOnly = true;
    document.getElementById("destNome").readOnly = true;
    document.getElementById("destCNPJ").readOnly = true;
    document.getElementById("emitNome").readOnly = true;
    document.getElementById("emitCNPJ").readOnly = true;
    
    $.ajax({
        url: 'index.php?m=emissornfe&c=emissornfecontroller&f=selecionaGrid',
        data: {
            ID: ID,
            destCNPJ : destCNPJ
        },
        type: 'POST',
        dataType: 'json',
        async: true,
        success: function(r) {
            
            document.getElementById("cUF").value = r[0];
            document.getElementById("cNF").value = r[1];
            document.getElementById("destNome").value = r[2];
            document.getElementById("destCNPJ").value = r[3];
            document.getElementById("emitNome").value = r[4];
            document.getElementById("emitCNPJ").value = r[5];
        },
        error: function(e) {

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

