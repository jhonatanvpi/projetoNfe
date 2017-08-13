<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>VPI Gestão</title>
        <meta charset="UTF-8"/>

          <!--PROGRESS BAR-->
        <script src="resources/geral/progress-bar/pace.min.js"></script>
        <link href="resources/geral/progress-bar/dataurl.css" rel="stylesheet">
        <!--PROGRESS BAR-->

        <!--JQUERY 1.11-->
        <link href="resources/geral/jquery/jquery-ui-1.11.2/jquery-ui.min.css" rel="stylesheet">
        <script src="resources/geral/jquery/jquery-1.11.1.min.js"></script>
        <script src="resources/geral/jquery/jquery-ui-1.11.2/jquery-ui.min.js"></script>
        <!--JQUERY 1.11-->

        <!--NOTIFICAÇÕES-->
        <link href="resources/geral/notificacoes/pnotify.custom.min.css" rel="stylesheet">
        <script src="resources/geral/notificacoes/pnotify.custom.min.js"></script>
        <!--NOTIFICAÇÕES-->

        <!--BOOSTRAP 3.3.0--> 
        <link href="resources/geral/bootstrap/css/cerulean-theme/bootstrap.min.css" rel="stylesheet">
        <script src="resources/geral/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!--BOOSTRAP 3.3.0--> 

        <!--DATEPICKER-->
        <link href="resources/geral/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
        <script src="resources/geral/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="resources/geral/bootstrap-datepicker/js/locales/bootstrap-datepicker.pt-BR.js" type="text/javascript"></script>
        <!--DATEPICKER-->

        <!--BLOCKUI-->
        <script src="resources/geral/blockUI/jquery.blockUI.js" type="text/javascript"></script>
        <!--BLOCKUI-->

        <!--GRID-->
        <link href="resources/geral/grid/css/dataTables.bootstrap.css" rel="stylesheet">
        <script src="resources/geral/grid/js/jquery.dataTables.min.js"></script>
        <script src="resources/geral/grid/js/dataTables.bootstrap.js"></script>
        <!--GRID-->

        <!--GERAL-->
        <link href="resources/geral/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="resources/geral/geral.css" rel="stylesheet">
        <link href="resources/geral/resetarScrollBar.css" rel="stylesheet">
        <script src="resources/geral/geral.js"></script>
        <!--GERAL-->

        <!-- EMISSOR NFE -->
        <script src="resources/recebimentonfe/js/recebimentonfe.js"></script>
       
        <!-- EMISSOR NFE -->
    </head>
    
    <body style="zoom: 85%;">
           <nav class="navbart">
            <div class="container-fluid" align="center">
                <a onclick="carregarArquivoXml()" class="btn btn-info">
                    <span class="glyphicon glyphicon-open"></span> XML 
                </a>
                <a onclick="mostrarModalPesquisa()" class="btn btn-info">
                    <span class="glyphicon glyphicon-question-sign"></span> Pesquisar NFE 
                </a>
            </div>
        </nav>
        <table style="width: 80%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                <tr>
                    <td  style="width: 5%;padding-right: 10px;font-size: 14px;">
                         <div class="form-group">
                             cUF
                             <input style="text-transform: uppercase;" type="text" class="form-control" id="cUF" placeholder="ID" readonly>
                         </div>
                    </td>
                    <td  style="width: 5%;padding-right: 10px;font-size: 14px;">
                         <div class="form-group">
                             cNF
                             <input style="text-transform: uppercase;" type="text" class="form-control" id="cNF" placeholder="ID" readonly>
                         </div>
                    </td>
           </tr>
           
        </table>
        <table style="width: 80%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                <tr>
                    <td  style="width: 5%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                             Nome
                             <input style="text-transform: uppercase;" type="text" class="form-control" id="emitNome" placeholder="ID" readonly>
                        </div>
                    </td>
                    <td  style="width: 5%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                             CNPJ
                             <input style="text-transform: uppercase;" type="text" class="form-control" id="emitCNPJ" placeholder="ID" readonly>
                        </div>
                    </td>
                    <td  style="width: 5%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                             Nome
                             <input style="text-transform: uppercase;" type="text" class="form-control" id="destNome" placeholder="ID" readonly>
                        </div>
                    </td>
                    <td  style="width: 5%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                             CNPJ
                             <input style="text-transform: uppercase;" type="text" class="form-control" id="destCNPJ" placeholder="ID" readonly>
                        </div>
                    </td>
                </tr>
           
        </table>
       
        <br><br>
        <div style='width: 99%; position: center; margin-left: 7px; margin-right: 4px; overflow-x: hidden'>
               <table id="grid" class="display" cellspacing="0" width="100%">
                   <thead>
                       <tr>
                           <th>NatOp</th>
                           <th>Nome</th>
                           <th>CPNJ</th>
                           <th>Rua</th>
                           <th>Número</th>
                           <th>Bairro</th>
                           <th>Fone</th>
                           <th>Selecionar</th>
                       </tr>
                   </thead>
               </table>
        </div>       
        <br>
        <HR WIDTH=100%>
        <br>

    </body>
    
    
    <!-- Modal XML -->
    <div class="modal fade" id="selecionarArquivoXml" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Notas Fiscais</h4>
                </div>
                <div class="modal-body">
                    <p><h4> Selecione nota fiscal (arquivo .xml)</h4></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Sair</button>
                    <button id="exampleFile" type="file" onclick="lidarComVariosArquivos()"class="btn btn-primary">Selecionar</button>
                    <input type="file" multiple="multiple" id="arquivoXml">
                </div>
            </div>
      </div>
    </div>
    
    <!-- FILTRO NFE --> 
    
    
    
    <!-- Modal -->
    <div class="modal fade" id="filtroNFE" tabindex="50" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog-esp">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pesquisa Notas Fiscais</h4>
                </div>
        
              
                <table style="width: 80%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <a>Dados Emissor</a>
                    <tr>
                        <td  style="padding-right: 5px;font-size: 14px;">
                            <div class="form">
                                Destinatário - Empresa
                                <select  id="CNPJFiltro" class="form-control"  readonly ></select>
                            </div>
                        </td>
                        
                        <td  style="padding-right: 5px;font-size: 14px;">
                            <div class="form">
                                Data Inicial
                                <input id="dataInicial" type="text" class="form-control" >
                            </div>
                        </td>
                        
                        <td  style="padding-right: 5px;font-size: 14px;">
                            <div class="form">
                                Data Final
                                <input id="dataFinal" type="text" class="form-control" >
                            </div>
                        </td>
                        
                    </tr>
                </table>
                
                <div class="modal-body">
                    <nav class="navbart">
                        <div class="container-fluid" align="center">
                            <a onclick="getGrid()" class="btn btn-info">
                                <span class="glyphicon glyphicon-search"></span> Pesquisar
                            </a>
                            <button type="button" class="btn btn-info" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"> Sair</button>
                        </div>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>   
      
</html>

<!--Carregar Xml <input id="input-1" type="file" class="file">-->