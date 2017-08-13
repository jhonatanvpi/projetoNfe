<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>VPI | Clarify</title>
        <meta charset="UTF-8"/> 
    <a href="emitirnfeview.php"></a>
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
         <link href="resources/emitirnfe/css/teste.css" rel="stylesheet">
        <link href="resources/geral/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="resources/geral/geral.css" rel="stylesheet">
        
        <link href="resources/geral/resetarScrollBar.css" rel="stylesheet">
        <script src="resources/geral/geral.js"></script>
        <!--GERAL-->

        <!-- CADASTRO FILIAL -->
        <script src="resources/emitirnfe/js/emitirnfe-tmp.js"></script>
        <!-- CADASTRO FILIAL -->
    </head>

    <body style="zoom: 85%;">

        
        <nav class="navbart">
            <div class="container-fluid" align="center">

                <a onclick="novaNFE()" class="btn btn-info">
                    <span class="glyphicon glyphicon-file"></span>  Novo 
                </a>
                <br><br>
                <ul id="abas" align="center">
                       <li><a href="#tab1">Cliente</a></li>
                       <li><a href="#tab2">Produtos</a></li>
                       <li><a href="#tab3">Transporte</a></li>
                       <li><a href="#tab4">Totais</a></li>
                       <li><a href="#tab5">Duplicatas</a></li>
                </ul>
            </div>
        </nav>
        

<!-- conteudo das abas -->
        <div class="container" align="center" style="width: 98%;">


            <fieldset class="fieldset-border">
            <legend class="legend-border" >Emissão NFE</legend>


            <div id="tab1" class="contaba" >


                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                        <tr>
                            <td  style="width: 20%; padding-right: 10px;font-size: 14px;">
                                <div class="form-group">
                                    Empresa
                                    <select   id="idEmpresa" class="form-control" onchange="carregarFilial()"  readonly></select>
                                </div>
                            </td>
                            <td  style="width: 20%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    Filial
                                    <input  type="livro" class="form-control" id="empresaFilial"  placeholder="Filial" readonly>
                                </div>
                           </td>
                           <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    CNPJ
                                    <input  type="livro" class="form-control" id="empresaCNPJ"  placeholder="CNPJ" readonly>
                                </div>
                           </td>
                            <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                                <div class="form-group">
                                    Inscrição Estadual
                                    <input  type="livro" class="form-control" id="empresaInscricaoEstadual"  placeholder="Est" readonly>
                                </div>
                            </td>
                            <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                                <div class="form-group">
                                    Inscrição Municipal
                                    <input  type="text" class="form-control" id="empresaInscricaoMunicipal" placeholder="Mun." readonly>
                                </div>
                            </td>
                                </tr>
                </table>


                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                        <tr>
                            <td  style="width: 40%; padding-right: 10px;font-size: 14px; ">
                               <div class="form-group">
                                    Endereço
                                    <input  type="text" class="form-control" id="empresaEndereco" placeholder="Endereço" readonly>
                                </div>
                            </td>
                            <td  style="width: 7%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    Número
                                    <input  type="text" class="form-control" id="empresaNumero" maxlength="18"  placeholder="Número" readonly>
                                </div>
                            </td>

                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    CEP
                                    <input  type="text" class="form-control" id="empresaCEP" placeholder="CEP" readonly>
                                </div>
                            </td>
                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                                  <div class="form-group">
                                    Cidade
                                    <input  type="text" class="form-control" id="empresaCidade" placeholder="Estado" readonly>
                                </div>
                            </td>
                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                                  <div class="form-group">
                                    Bairro
                                    <input  type="text" class="form-control" id="empresaBairro" placeholder="Estado" readonly>
                                </div>
                            </td>
                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                                  <div class="form-group">
                                    Estado
                                    <input  type="text" class="form-control" id="empresaEstado" placeholder="Estado" readonly>
                                </div>
                            </td>
                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                                  <div class="form-group">
                                    País
                                    <input  type="text" class="form-control" id="empresaPais" placeholder="País" readonly>
                                </div>
                            </td>


                      </tr>
                </table>
                <table style="width: 90%; height: 79px; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                        <tr>

                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                                  <div class="form-group">
                                    Nome da venda
                                    <input  type="text" class="form-control" id="empresaVenda" placeholder="Venda" readonly>
                                </div>
                            </td>
                            <td style="width: 10%;padding-right: 10px;font-size: 14px;">
                                <div class="form-group">
                                    CFOP Dentro do Estado
                                    <select id="cfopDentroDoEstado" class="form-control" readonly>
                                            <option readonly value="0">Selecione</option>
                                            <option readonly value="5101">5101 - Venda de produção do estabelecimento</option>
                                            <option readonly value="6101">6101 - Venda de produção do estabelecimento</option>
                                            <option readonly value="5949">5949 - Outra saída de mercadoria ou prestação de serviço não especificado</option>
                                            <option readonly value="6949">6949 - Outra saída de mercadoria ou prestação de serviço não especificado</option>
                                    </select> 
                                </div>
                            </td>
                            <td  style="width: 15%; padding-right: 10px; font-size: 14px;">
                               <div class="form-group">
                                   CFOP Fora do Estado
                                    <select id="cfopForaDoEstado" class="form-control" readonly>
                                            <option readonly value="0">Selecione</option>
                                            <option readonly value="5101">5101 - Venda de produção do estabelecimento</option>
                                            <option readonly value="6101">6101 - Venda de produção do estabelecimento</option>
                                            <option readonly value="5949">5949 - Outra saída de mercadoria ou prestação de serviço não especificado</option>
                                            <option readonly value="6949">6949 - Outra saída de mercadoria ou prestação de serviço não especificado</option>
                                    </select> 
                               </div>
                            </td>
                            </td>
                            <td  style="width: 15%; padding-right: 10px; font-size: 14px;">
                               <div class="form-group">
                                    Finalidade
                                    <select id="finalidade" class="form-control" readonly>
                                            <option readonly value="0">Normal</option>
                                            <option readonly value="1">Complementar</option>
                                            <option readonly value="2">Ajuste</option>
                                            <option readonly value="3">Devoluçao</option>
                                    </select> 
                               </div>
                            </td>

                    </tr>
                </table>

                <table style="width: 90%; height: 79px; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <td style="width: 10%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                            Data de saída
                            <input type="text" class="form-control" id="dataSaida"   placeholder="Data de saída" >
                        </div>
                    </td>
                    <td style="width: 4%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                            Hora de saída
                            <input type="text" class="form-control" id="horaSaida">
                        </div>
                    </td>
                    <td  style="width: 30%; padding-right: 10px;font-size: 14px;"></td>
                    <td style="width: 10%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                            Data emissão
                            <input type="text" class="form-control" id="dataEmissao"   placeholder="Data de emissão">
                        </div>
                    </td>
                    <td style="width: 4%;padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                            Horário emissão
                            <input type="text" class="form-control" id="horaEmissao"   placeholder="Data Demissão">
                        </div>
                    </td>
                </table>

                <table style="width: 90%; height: 79px; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                    <div class="form-group">
                      Origem do Documento
                      <input  type="text" class="form-control" id="origemDoDocumento" placeholder="Venda">
                    </div>
                </td> 
                </table>
            </div>


            <div id="tab2" class="contaba">

                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                        <tr>
                            <td  style="width: 10%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    Descrição
                                    <select   id="descProd" class="form-control" onchange="carregarItem()"></select>
                                </div>
                           </td>
                            <td  style="width: 22%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    Código do Item
                                    <select   id="codProd" class="form-control" onchange="carregarCod()"></select>
                                </div>
                           </td>
                           <td  style="width: 22%; padding-right: 10px;font-size: 14px;">
                               <div class="form-group">
                                    NCM
                                    <input type="text" class="form-control" id="ncmProd"   placeholder="NCM">
                                </div>
                           </td>
                        </tr>
                </table>
                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <td  style="width: 22%; padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                            Preço
                            <input type="text" class="form-control" id="precoProd"   placeholder="NCM">
                        </div>
                    </td>
                    <td  style="width: 22%; padding-right: 10px;font-size: 14px;">
                        <div class="form-group">
                            Quantidade
                            <input type="text" class="form-control" id="qtProd"   placeholder="NCM">
                        </div>
                    </td>
                    <td  style="width: 15%; padding-right: 10px; font-size: 14px;">
                        <div class="form-group">
                            Origem
                            <select id="origem" class="form-control" readonly>
                                    <option readonly value="0">0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;</option>
                                    <option readonly value="1">1 - Estrangeira - Importação direta, exceto a indicada no código 6;</option>
                                    <option readonly value="2">2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;</option>
                            </select> 
                        </div>
                    </td>
                    <td  style="width: 15%; padding-right: 10px; font-size: 14px;">
                        <div class="form-group">
                            CFOP Dentro do Estado
                            <select id="cfopForaDoEstado" class="form-control" readonly>
                                    <option readonly value="0">Selecione</option>
                                    <option readonly value="5101">5101 - Venda de produção do estabelecimento</option>
                                    <option readonly value="6101">6101 - Venda de produção do estabelecimento</option>
                                    <option readonly value="5949">5949 - Outra saída de mercadoria ou prestação de serviço não especificado</option>
                                    <option readonly value="6949">6949 - Outra saída de mercadoria ou prestação de serviço não especificado</option>
                            </select> 
                        </div>
                    </td>
                </table>

                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <tr> 
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                IPI CST
                                <select id="ipiCST" class="form-control" readonly>
                                    <option readonly value="00">00 - Entrada com recuperação de crédito</option>
                                    <option readonly value="01">01 - Entrada tributada com alíquota zero</option>
                                    <option readonly value="02">02 - Entrada isenta</option>
                                    <option readonly value="03">03 - Entrada não-tributada</option>
                                    <option readonly value="04">04 - Entrada imune</option>
                                </select>
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                ICMS CST
                                <select id="icms" class="form-control" readonly>
                                    <option readonly value="0">Selecione</option>
                            </select>
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                PIS CST
                                <select id="pisCST" class="form-control" readonly>
                                    <option readonly value="00">00 - Operação Tributável com Alíquota Básica</option>
                                    <option readonly value="01">01 - Operação Tributável com Alíquota Diferenciada</option>
                                    <option readonly value="02">02 - Operação Tributável com Alíquota por Unidade de Medida de Produto</option>
                                </select>
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                COFINS CST
                                <select id="cofinsCST" class="form-control" readonly>
                                    <option readonly value="00">00 - Operação Tributável com Alíquota Básica</option>
                                    <option readonly value="01">01 - Operação Tributável com Alíquota Diferenciada</option>
                                    <option readonly value="02">02 - Operação Tributável com Alíquota por Unidade de Medida de Produto</option>
                                </select>
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                IPI
                                <input type="text" class="form-control" id="ipiProd"   placeholder="NCM">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                ICMS
                                <input type="text" class="form-control" id="icmsProd"   placeholder="NCM">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                PIS
                                <input type="text" class="form-control" id="pisProd"   placeholder="NCM">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                COFINS
                                <input type="text" class="form-control" id="cofinsProd"   placeholder="NCM">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>


            <div id="tab3" class="contaba">

                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <tr>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Modalidade do Frete
                                <select id="modalidadeFrete" class="form-control" readonly>
                                    <option readonly value="00">0 - Por conta do emitente</option>
                                    <option readonly value="01">1 - Por conta do destinatário</option>
                                    <option readonly value="02">2 - Por conta de terceiros</option>
                                    <option readonly value="02">3 - Sem Frete</option>
                                </select>
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Transportadora
                                <select id="transportadora" class="form-control" readonly>
                                    <option readonly value="0">MIND42</option>
                                </select>
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Placa do Veículo
                                <input type="text" class="form-control" id="placaVeiculo"   placeholder="NCM">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                UF do Veículo
                                <input type="text" class="form-control" id="ufVeiculo"   placeholder="NCM">
                            </div>
                        </td>   
                    </tr>
                </table>  
                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <tr>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Quantidade
                                <input type="text" class="form-control" id="prodQuantidade"   placeholder="Quantidade">
                            </div>
                        </td> 
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Espécio
                                <input type="text" class="form-control" id="prodEspecie"   placeholder="Espécie">
                            </div>
                        </td> 
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Marca
                                <input type="text" class="form-control" id="prodMarca"   placeholder="Marca">
                            </div>
                        </td> 
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Numeração
                                <input type="text" class="form-control" id="prodNumeracao"   placeholder="Numeração">
                            </div>
                        </td> 
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Peso Bruto
                                <input type="text" class="form-control" id="pesoBruto"   placeholder="Peso Bruto">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Peso Líquido
                                <input type="text" class="form-control" id="pesoLiquido"   placeholder="Peso Líquido">
                            </div>
                        </td> 
                    </tr>
                </table>  
                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <td>
                        Observações
                        <input type="text" class="form-control" id="prodObs"   placeholder="Observações">
                    </td>
                </table>
            </div>
            
            
            <div id="tab4" class="contaba">

                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <tr>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            Tipo de Atendimento
                            <select id="totAtendimento" class="form-control" readonly>
                                    <option readonly value="0">0 - Não se aplica</option>
                                    <option readonly value="1">1 - Operação Presencial</option>
                                    <option readonly value="2">2 - Operação não Presencial, pela Internet</option>
                                    <option readonly value="3">3 - Operação não Presencial, Teleatendimento</option>
                                    <option readonly value="4">4 - NFC-e em operação com entrega a domicílio</option>
                                    <option readonly value="5">5 - Operação não presencial, outros</option>
                            </select>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            Indicador de Pagamento
                            <select id="totPagamento" class="form-control" readonly>
                                    <option readonly value="0">0 - Pagamento à vista</option>
                                    <option readonly value="1">1 - Pagamento a prazo</option>
                                    <option readonly value="2">2 - Outros</option>
                            </select>
                        </td>
                        
                    </tr>
                    
                </table>
               
                <table style="width: 90%; border-collapse: collapse" cellpadding="0" cellspacing="5px" align="center" >
                    <tr>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Valor ret. de PIS
                                <input type="text" class="form-control" id="totRetPis"   placeholder="Observações">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Valor ret. de COFINS
                                <input type="text" class="form-control" id="totRetCofins"   placeholder="Observações">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Valor ret. de CSLL
                                <input type="text" class="form-control" id="totRetCSLL"   placeholder="Observações">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                BC de IRRF
                                <input type="text" class="form-control" id="totBcIRRF"   placeholder="Observações">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Valor ret. de IRRF
                                <input type="text" class="form-control" id="totRetIRRF"   placeholder="Observações">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                BC de prev. social
                                <input type="text" class="form-control" id="totBcPrev"   placeholder="Observações">
                            </div>
                        </td>
                        <td  style="width: 12%; padding-right: 10px;font-size: 14px;">
                            <div class="form-group">
                                Valor ret. de prev. social
                                <input type="text" class="form-control" id="totValorRetPrev"   placeholder="Observações">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            </fieldset>
        </div>        
    </body>
</html>