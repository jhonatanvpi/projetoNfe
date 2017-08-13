<?php


error_reporting(E_ALL);
ini_set('display_errors', 'On');
//include_once 'nfephp/bootstrap.php';


class recebimentonfemodel extends CI_Model {

    private $conBanco;

    public function __construct() {
        parent::__construct();
    }

    private function initConBanco() {
        if ($this->conBanco == null) {
            $this->conBanco = $this->load->database("engsys", TRUE);
        }
    }

    private function getUsuarioLogado() {
        
        $this->load->library("access");

        return $this->access->getUsuarioLogado();
    }

    private function String($toString){
        
        if (is_array($toString)){
            for($i = 0; $i < count($toString); $i++){
                $toString[$i] = (string)$toString[$i];
            }
        }
        else{
            $toString = (string)$toString;
        }
        return $toString;
    }
    
    private function printBancoTest($name,$PK){
        $this->initConBanco();
        $query = "SELECT * FROM $name WHERE IDE_NNF=$PK";
        $rs = $this->conBanco->query($query)->result();
        print_r($rs);exit();
    }
    
    
    public function carregarEmpresas() {

        $this->initConBanco();
        $query = "SELECT DISTINCT DEST_CNPJ, DEST_XNOME FROM NFE ORDER BY DEST_XNOME";
        //print_r($query);exit();
        $rs = $this->conBanco->query($query)->result();
        $html = "<option value='0'>Selecione</option>";
 
        if (is_array($rs) && count($rs) > 0) {
            foreach ($rs as $item) {
                $destCNPJ = $item->DEST_CNPJ;
                $destEmpresa = $item->DEST_XNOME;
                //$html .= "<option value='$DEST_XNOMEidFuncionario'>$nomeFuncionario</option>";
                $html .= "<option value='$destCNPJ'>$destEmpresa</option>";
            }
            return $html;
        } 
        else {
            return "<option value='0'>Nenhuma Empresa Cadastrada</option>";
        }
    }  
    
    
    private function formatarData($data){
        $newData = str_replace("-", "/", substr($data,0,10));
        return $newData;
    }
    
    
    private function arrumarData($dataNaoFormatada){
        $data = $this->formatarData($dataNaoFormatada);
        $ano = substr($data,0,4);
        $mes = substr($data,5,2);
        $dia = substr($data,8,2);
        $newData = $dia . '/' . $mes . '/' . $ano;
        return $newData;
    }
    
    
    private function salvarXMLemBanco($INFNFE,$NNF,$destCNPJ,$ideValues,$emitValues,$destValues,
                                      $prodValues, $impostoValues, $infAdProd, $totalValues,$transpValues,
                                      $cobrValues,$infAdicfinal,$dataInicial,$dataFinal){
        
                                
        //$this->printBancoTest("NFE",(int)$NNF);exit();
        $this->initConBanco();
        $query = "SELECT * FROM NFE WHERE IDE_NNF= $NNF";// AND DEST_CNPJ= $destCNPJ";
        $rs = $this->conBanco->query($query)->result();
        
        $usuarioLogado = $this->getUsuarioLogado()->NOME_COMPLETO; 

        if (is_array($rs) && count($rs) > 0){
            //print_r('already exists');exit();
        }
        
        else{

            $query = "INSERT INTO NFE           (IDE_CUF,IDE_CNF, IDE_NATOP, IDE_INDPAG,
                                                IDE_MOD, IDE_SERIE, IDE_NNF, IDE_DHEMI,
                                                IDE_DHSAIENT, IDE_TPNF, IDE_IDDEST, 
                                                IDE_CMUNFG, IDE_TPIMP, IDE_TPEMIS,
                                                IDE_CDV, IDE_TPAMB, IDE_FINNFE, IDE_INDFINAL,IDE_INDPRES,
                                                IDE_PROCEMI, IDE_VERPROC,
                                                
                                                EMIT_CNPJ, EMIT_XNOME, EMIT_XFANT,
                                                EMIT_XLGR, EMIT_NRO, EMIT_XCPL, EMIT_XBAIRRO,
                                                EMIT_CMUN, EMIT_XMUN, EMIT_UF, EMIT_CEP,
                                                EMIT_CPAIS, EMIT_XPAIS, EMIT_FONE, EMIT_IE,
                                                EMIT_CRT, 
                                                
                                                DEST_CNPJ, DEST_XNOME, DEST_XLGR, DEST_NRO, DEST_XBAIRRO,
                                                DEST_CMUN, DEST_XMUN, DEST_UF, DEST_CEP, DEST_CPAIS,
                                                DEST_XPAIS, DEST_FONE, DEST_INDIEDEST, DEST_IE,
                                                
                                                PROD_CPROD, PROD_CEAN, PROD_XPROD, PROD_NCM, PROD_CFOP, 
                                                PROD_UCOM, PROD_QCOM, PROD_VUNCOM, PROD_VPROD, PROD_CEANTRIB,
                                                PROD_UTRIB, PROD_QTRIB, PROD_VUNTRIB, PROD_INDTOT,
                                                
                                                IMPOSTO_VTOTTRIB, IMPOSTO_ICMS_ORIG, IMPOSTO_ICMS_CST,
                                                IMPOSTO_ICMS_MODBC, IMPOSTO_ICMS_VBC, IMPOSTO_ICMS_PICMS,
                                                IMPOSTO_ICMS_VICMS, IMPOSTO_IPI_CENQ, IMPOSTO_IPI_CST,
                                                IMPOSTO_PIS_CST, IMPOSTO_PIS_VBC, IMPOSTO_PIS_PPIS,
                                                IMPOSTO_PIS_VPIS, IMPOSTO_CONFINS_CST, IMPOSTO_CONFINS_VBC,
                                                IMPOSTO_CONFINS_PCONFINS, IMPOSTO_CONFINS_VCONFINS,
                                                
                                                INFADPROD,
                                                
                                                TOTAL_VBC, TOTAL_VICMS, TOTAL_VICMSDESON, TOTAL_VBCST,
                                                TOTAL_VST, TOTAL_VPROD, TOTAL_VFRETE, TOTAL_VSEG,
                                                TOTAL_VDESC, TOTAL_VII, TOTAL_VIPI, TOTAL_VPIS, TOTAL_VCONFINS,
                                                TOTAL_VOUTRO, TOTAL_VNF, TOTAL_VTOTTRIB, 
                                                
                                                TRANSP_MODFRETE, TRANSP_XNOME, TRANSP_XENDER, TRANSP_XMUN,
                                                TRANSP_UF,TRANSP_VEIC_PLACA, TRANSP_VEIC_UF, TRANSP_VOL_PESOL,
                                                TRANSP_VOL_PESOB, 
                                                
                                                COBR_NDUP, COBR_DVENC, COBR_VDUP, 
                                                
                                                INFADIC_INFCPL,
                                                
                                                DATA_CADASTRO, USUARIO_CADASTRO,
                                                
                                                DATA_INICIAL_NFE, DATA_FINAL_NFE,
                                                
                                                INF_NFE)
                                                

                    VALUES (                    '$ideValues[0]',  '$ideValues[1]',  '$ideValues[2]',
                                                '$ideValues[3]',  '$ideValues[4]',  '$ideValues[5]',
                                                 $ideValues[6],   '$ideValues[7]',  '$ideValues[8]',
                                                '$ideValues[9]',  '$ideValues[10]', '$ideValues[11]',
                                                '$ideValues[12]', '$ideValues[13]', '$ideValues[14]',
                                                '$ideValues[15]', '$ideValues[16]', '$ideValues[17]',
                                                '$ideValues[18]', '$ideValues[19]', '$ideValues[20]',
                                                    
                                                '$emitValues[0]',  '$emitValues[1]',  '$emitValues[2]', 
                                                '$emitValues[3]',  '$emitValues[4]',  '$emitValues[5]',
                                                '$emitValues[6]',  '$emitValues[7]',  '$emitValues[8]', 
                                                '$emitValues[9]',  '$emitValues[10]', '$emitValues[11]', 
                                                '$emitValues[12]', '$emitValues[13]', '$emitValues[14]', 
                                                '$emitValues[15]', 
                                                
                                                '$destValues[0]',  '$destValues[1]',  '$destValues[2]', 
                                                '$destValues[3]',  '$destValues[4]',  '$destValues[5]', 
                                                '$destValues[6]',  '$destValues[7]',  '$destValues[8]', 
                                                '$destValues[9]',  '$destValues[10]', '$destValues[11]', 
                                                '$destValues[12]', '$destValues[13]',
                                                    
                                                '$prodValues[0]',  '$prodValues[1]',  '$prodValues[2]', 
                                                '$prodValues[3]',  '$prodValues[4]',  '$prodValues[5]', 
                                                '$prodValues[6]',  '$prodValues[7]',  '$prodValues[8]', 
                                                '$prodValues[9]',  '$prodValues[10]', '$prodValues[11]', 
                                                '$prodValues[12]', '$prodValues[13]', 
                                                    
                                                '$impostoValues[0]',  '$impostoValues[1]',  '$impostoValues[2]', 
                                                '$impostoValues[3]',  '$impostoValues[4]',  '$impostoValues[5]', 
                                                '$impostoValues[6]',  '$impostoValues[7]',  '$impostoValues[8]', 
                                                '$impostoValues[9]',  '$impostoValues[10]', '$impostoValues[11]', 
                                                '$impostoValues[12]', '$impostoValues[13]', '$impostoValues[14]', 
                                                '$impostoValues[15]', '$impostoValues[16]',
                                                    
                                                '$infAdProd',
                                                 
                                                '$totalValues[0]',  '$totalValues[1]',  '$totalValues[2]', 
                                                '$totalValues[3]',  '$totalValues[4]',  '$totalValues[5]', 
                                                '$totalValues[6]',  '$totalValues[7]',  '$totalValues[8]', 
                                                '$totalValues[9]',  '$totalValues[10]', '$totalValues[11]', 
                                                '$totalValues[12]', '$totalValues[13]', '$totalValues[14]', 
                                                '$totalValues[15]',
                                                    
                                                '$transpValues[0]', '$transpValues[1]', '$transpValues[2]', 
                                                '$transpValues[3]', '$transpValues[4]', '$transpValues[5]', 
                                                '$transpValues[6]', '$transpValues[7]', '$transpValues[8]', 
                                                    
                                                '$cobrValues[0]', '$cobrValues[0]', '$cobrValues[0]',
                                                    
                                                '$infAdicfinal', 
                                                
                                                SYSDATE, '$usuarioLogado' ,
                                                
                                                '$dataInicial', '$dataFinal','$INFNFE')";
            //print_r($query);exit();
            
            $resultado = $this->conBanco->query($query);
            
            if($resultado == true || $resultado == 1){
                return true;            
            }
            else{
                return false;
            }
        }
    
       
    }
    
    public function xmlParser($enderecoXml){
        
        if (file_exists($enderecoXml)) {
            
            $xml = simplexml_load_file($enderecoXml);
            //print_r($xml);
            //print_r($xml);exit();
            $infNFe = $xml->children();
            $info = $infNFe->children();
            //print_r($info);exit();
            $ide        = $info[0];
            $emit       = $info[1];
            $dest       = $info[2];
            $det        = $info[3];
            $total      = $info[4]->ICMSTot;
            $transp     = $info[5];
            $cobr       = $info[6]->dup;
            $infAdic    = $info[7];
            
            /*
             * Valores do ide
             */
            $dataI = (string)($ide[0]->dhEmi);
            $dataF   = (string)$ide[0]->dhSaiEnt;
            $dataInicial = $this->arrumarData($dataI);
            $dataFinal = $this->arrumarData($dataF);
            
            $INFNFE = (string)$xml->infNFe[0]['Id'][0];

            $ideValues = [$ide[0]->cUF,$ide[0]->cNF, $ide[0]->natOp, $ide[0]->indPag,
                          $ide[0]->mod, $ide[0]->serie, $ide[0]->nNF, $ide[0]->dhEmi,
                          $ide[0]->dhSaiEnt, $ide[0]->tpNF, $ide[0]->idDest, $ide[0]->cMunFG,
                          $ide[0]->tpImp, $ide[0]->tpEmis, $ide[0]->cDV, $ide[0]->tpAmb,
                          $ide[0]->finNFe, $ide[0]->indFinal, $ide[0]->indPres, $ide[0]->procEmi,
                          $ide[0]->verProc];
            /*
             * Valores do emit, tem mais um "filho" enderEmit
             */
            
            $enderEmit = $emit[0]->children()->enderEmit[0];
            $emitValues = [$emit[0]->CNPJ, $emit[0]->xNome, $emit[0]->xFant, 
                           $enderEmit[0]->xLgr,$enderEmit[0]->nro,$enderEmit[0]->xCpl, 
                           $enderEmit[0]->xBairro,$enderEmit[0]->cMun,$enderEmit[0]->xMun,
                           $enderEmit[0]->UF,$enderEmit[0]->CEP,$enderEmit[0]->cPais,
                           $enderEmit[0]->xPais,$enderEmit[0]->fone,$emit[0]->IE,$emit[0]->CRT];
                           
            /*
             * Valores do destinatário
             */
            $enderDest = $dest[0]->children()->enderDest[0];
            $destValues = [$dest[0]->CNPJ, $dest[0]->xNome, $enderDest[0]->xLgr, $enderDest[0]->nro, 
                           $enderDest[0]->xBairro, $enderDest[0]->cMun, $enderDest[0]->xMun, $enderDest[0]->UF, 
                           $enderDest[0]->CEP, $enderDest[0]->cPais, $enderDest[0]->xPais, $enderDest[0]->fone,$dest[0]->indIEDest,
                           $dest[0]->IE];
            
            /*
             * Valores do produto
             */
            
            $prod = $det->prod;
            $prodValues = [$prod[0]->cProd, $prod[0]->cEAN, $prod[0]->xProd, $prod[0]->NCM, 
                           $prod[0]->CFOP, $prod[0]->uCom, $prod[0]->qCom, $prod[0]->vUnCom, 
                           $prod[0]->vProd, $prod[0]->cEANTrib, $prod[0]->uTrib, $prod[0]->qTrib,
                           $prod[0]->vUnTrib, $prod[0]->indTot];
            
            
            
            $imposto = $det->imposto;
            $ICMS00  = $imposto->ICMS->ICMS00;
            $IPI     = $imposto->IPI;
            $PIS     = $imposto->PIS->PISAliq;
            $COFINS  = $imposto->COFINS->COFINSAliq;
            
            $impostoValues = [$imposto[0]->vTotTrib, $ICMS00[0]->orig, $ICMS00[0]->CST, 
                              $ICMS00[0]->modBC, $ICMS00[0]->vBC, $ICMS00[0]->pICMS, 
                              $ICMS00[0]->vICMS,$IPI->cEnq,$IPI->IPINT[0]->CST,
                              $PIS[0]->CST, $PIS[0]->vBC, $PIS[0]->pPIS, $PIS[0]->vPIS,
                              $COFINS[0]->CST, $COFINS[0]->vBC, $COFINS[0]->pCOFINS, 
                              $COFINS[0]->vCOFINS];
            
            $infAdProd = $det->infAdProd[0];
            
            $totalValues = [$total->vBC, $total->vICMS, $total->vICMSDeson, $total->vBCST, 
                            $total->vST, $total->vProd, $total->vFrete, $total->vSeg, 
                            $total->vDesc, $total->vII, $total->vIPI, $total->vPIS,
                            $total->vCOFINS, $total->vOutro, $total->vNF, $total->vTotTrib];
            
            
            $transpValues = [$transp->modFrete,$transp->transporta[0]->xNome,
                             $transp->transporta[0]->xEnder,$transp->transporta[0]->xMun,$transp->transporta[0]->UF,
                             $transp->veicTransp[0]->placa, $transp->veicTransp[0]->UF, $transp->vol[0]->pesoL, 
                             $transp->vol[0]->pesoB];
            
            $cobrValues = [$cobr[0]->nDup, $cobr[0]->dVenc, $cobr[0]->vDup];
            
            $infAdicFinal = $infAdic->infCpl;
    
            $this->salvarXMLemBanco($INFNFE, $ide[0]->nNF, $dest[0]->CNPJ, $this->String($ideValues), $this->String($emitValues), 
                                    $this->String($destValues), $this->String($prodValues), $this->String($impostoValues),
                                    $this->String($infAdProd), $this->String($totalValues), $this->String($transpValues), 
                                    $this->String($cobrValues), $this->String($infAdicFinal),(string)$dataInicial,(string)$dataFinal);
            
        
            
        }
        else {
            exit('Falha ao abrir test.xml.');
        }  
        
        
        return "fim";
      
    }
    
    
    public function getGrid($draw,$CNPJFiltro,$dataInicialFiltro,$dataFinalFiltro){
        
        $this->initConBanco();
        $query = "SELECT * FROM NFE WHERE 1=1 ";
        $itens = $this->conBanco->query($query)->result();
        if (strlen($CNPJFiltro) > 1) {
            $query .= "AND DEST_CNPJ = '$CNPJFiltro'";
        }
        
        if(strlen($dataInicialFiltro) > 1){
            $query .= " AND DATA_INICIAL_NFE > '$dataInicialFiltro'";
        }
        if(strlen($dataFinalFiltro) > 1){
            $query .= " AND DATA_FINAL_NFE < '$dataFinalFiltro'";
        }
        //print_r($query);exit();
        $obj = array();
        
        $count = $this->getCountGrid();
        //print_r($count);exit();
        $grid = array();

        $grid['draw'] = $draw; // mecanismo de conformidade
        $grid['recordsTotal'] = $count; // total de registros 
        $grid['recordsFiltered'] = $count; // tota de registros filtrados

        $data = array(); // linhas
        //$itens = $this->getDataGrid($indice, $ordem, $inicio, $tamanho, $parametro1, $parametro2);
        
        //print_r($query);exit();
        $itens = $this->conBanco->query($query)->result();
        
        $obj = array();
                   
        foreach ($itens as $item) {
            
            $aux           = $item->IDE_NNF;
            $natOp         = $item->IDE_NATOP;
            $destNome      = $item->DEST_XNOME;
            $destCNPJ      = $item->DEST_CNPJ;
            $destRua       = $item->DEST_XLGR;
            $destNro       = $item->DEST_NRO; 
            $destBairro    = $item->DEST_XBAIRRO; 
            $destFone      = $item->DEST_FONE;
            
            $obj['IDE_NATOP'] = $natOp;
            $obj['DEST_XNOME'] = $destNome;
            $obj['DEST_CNPJ'] = $destCNPJ;
            $obj['DEST_XLGR'] = $destRua;
            $obj['DEST_NRO'] = $destNro;
            $obj['DEST_XBAIRRO'] = $destBairro;
            $obj['DEST_FONE'] = $destFone;
            $obj['SELECIONAR'] = "<button type='submit' class='btn-primary' onclick='selecionaGrid($aux,$destCNPJ)'>SELECIONAR</button>";
          
            $data[] = $obj;
        }

        $grid['data'] = $data;

        return $grid;
        
        
    }
    
    
    private function getCountGrid(){
        
        $this->initConBanco();
        $query = "SELECT * FROM NFE";
        $rs = $this->conBanco->query($query)->result();
        //print_r($rs);exit();
        
        $query2 = "SELECT COUNT(IDE_NNF) AS TOTAL FROM NFE";
        //print_r($query);exit();
        $rs = $this->conBanco->query($query2)->result();
        
        if (is_array($rs) && count($rs) > 0) {
            return $rs[0]->TOTAL;
        } else {
            return 0;
        }        
          
    }
    
    public function selecionaGrid($NFF, $destCNPJ){
        $this->initConBanco();
        
        $query = "SELECT * FROM NFE WHERE IDE_NNF=$NFF";
        //print_r($query);exit();
        $rs    = $this->conBanco->query($query)->result();
        
        $obj = array();
           
        if (is_array($rs) && count($rs) > 0){
            
            $obj[] = $rs[0]->IDE_CUF;
            $obj[] = $rs[0]->IDE_CNF;
            $obj[] = $rs[0]->EMIT_XNOME;
            $obj[] = $rs[0]->EMIT_CNPJ;
            $obj[] = $rs[0]->DEST_XNOME;
            $obj[] = $rs[0]->DEST_CNPJ;
                
            return json_encode($obj);
        }
        else{
            return false;
        }
        
    }
    
    
    public function emitirNfe(){
               
        
        $nfe = new NFePHP\NFe\MakeNFe();
              
        $nfeTools = new NFePHP\NFe\ToolsNFe('NFePHP/config/config.json');

        //Dados da NFe - infNFe
        $cUF = '42'; //codigo numerico do estado
             
        
        $cNF = '00000010'; //numero aleatório da NF
        $natOp = 'Venda de Produto'; //natureza da operação
        $indPkag = '1'; //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
        $mod = '55'; //modelo da NFe 55 ou 65 essa última NFCe
        $serie = '2'; //serie da NFe
        $nNF = '10'; // numero da NFe
        $dhEmi = date("Y-m-d\TH:i:sP"); //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
        $dhSaiEnt = date("Y-m-d\TH:i:sP"); //Não informar este campo para a NFC-e.
        $tpNF = '1';
        $idDest = '3'; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
        $cMunFG = '4202305';
        $tpImp = '3'; //0=Sem geração de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem;
        //3=DANFE Simplificado; 4=DANFE NFC-e; 5=DANFE NFC-e em mensagem eletrônica
        //(o envio de mensagem eletrônica pode ser feita de forma simultânea com a impressão do DANFE;
        //usar o tpImp=5 quando esta for a única forma de disponibilização do DANFE).
        $tpEmis = '1'; //1=Emissão normal (não em contingência);
        //2=Contingência FS-IA, com impressão do DANFE em formulário de segurança;
        //3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional);
        //4=Contingência DPEC (Declaração Prévia da Emissão em Contingência);
        //5=Contingência FS-DA, com impressão do DANFE em formulário de segurança;
        //6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
        //7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
        //9=Contingência off-line da NFC-e (as demais opções de contingência são válidas também para a NFC-e);
        //Nota: Para a NFC-e somente estão disponíveis e são válidas as opções de contingência 5 e 9.
        $tpAmb = '2'; //1=Produção; 2=Homologação
        $finNFe = '1'; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
        $indFinal = '0'; //0=Normal; 1=Consumidor final;
        $indPres = '9'; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
        //1=Operação presencial;
        //2=Operação não presencial, pela Internet;
        //3=Operação não presencial, Teleatendimento;
        //4=NFC-e em operação com entrega a domicílio;
        //9=Operação não presencial, outros.
        $procEmi = '0'; //0=Emissão de NF-e com aplicativo do contribuinte;
        //1=Emissão de NF-e avulsa pelo Fisco;
        //2=Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
        //3=Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
        $verProc = '4.0.43'; //versão do aplicativo emissor
        $dhCont = ''; //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
        $xJust = ''; //Justificativa da entrada em contingência
//Numero e versão da NFe (infNFe)
        $ano = date('y', strtotime($dhEmi));
        $mes = date('m', strtotime($dhEmi));
        $cnpj = $nfeTools->aConfig['cnpj'];
        $chave = $nfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $nNF, $tpEmis, $cNF);
                       
        
        $versao = '3.10';
        $resp = $nfe->taginfNFe($chave, $versao);

        $cDV = substr($chave, -1); //Digito Verificador da Chave de Acesso da NF-e, o DV é calculado com a aplicação do algoritmo módulo 11 (base 2,9) da Chave de Acesso.
//tag IDE
        $resp = $nfe->tagide($cUF, $cNF, $natOp, $indPag, $mod, $serie, $nNF, $dhEmi, $dhSaiEnt, $tpNF, $idDest, $cMunFG, $tpImp, $tpEmis, $cDV, $tpAmb, $finNFe, $indFinal, $indPres, $procEmi, $verProc, $dhCont, $xJust);

       
        
//refNFe NFe referenciada  
//$refNFe = '12345678901234567890123456789012345678901234';
//$resp = $nfe->tagrefNFe($refNFe);
//refNF Nota Fiscal 1A referenciada
//$cUF = '35';
//$AAMM = '1312';
//$CNPJ = '12345678901234';
//$mod = '1A';
//$serie = '0';
//$nNF = '1234';
//$resp = $nfe->tagrefNF($cUF, $AAMM, $CNPJ, $mod, $serie, $nNF);
//NFPref Nota Fiscal Produtor Rural referenciada
//$cUF = '35';
//$AAMM = '1312';
//$CNPJ = '12345678901234';
//$CPF = '123456789';
//$IE = '123456';
//$mod = '1';
//$serie = '0';
//$nNF = '1234';
//$resp = $nfe->tagrefNFP($cUF, $AAMM, $CNPJ, $CPF, $IE, $mod, $serie, $nNF);
//CTeref CTe referenciada
//$refCTe = '12345678901234567890123456789012345678901234';
//$resp = $nfe->tagrefCTe($refCTe);
//ECFref ECF referenciada
//$mod = '90';
//$nECF = '12243';
//$nCOO = '111';
//$resp = $nfe->tagrefECF($mod, $nECF, $nCOO);
//Dados do emitente - (Importando dados do config.json)
        $CNPJ = $nfeTools->aConfig['cnpj'];
        $CPF = ''; // Utilizado para CPF na nota
        $xNome = $nfeTools->aConfig['razaosocial'];
        $xFant = $nfeTools->aConfig['nomefantasia'];
        $IE = $nfeTools->aConfig['ie'];
        $IEST = $nfeTools->aConfig['iest'];
        $IM = $nfeTools->aConfig['im'];
        $CNAE = $nfeTools->aConfig['cnae'];
        $CRT = $nfeTools->aConfig['regime'];
        $resp = $nfe->tagemit($CNPJ, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);

//endereço do emitente
        $xLgr = 'RUA: TREZE DE MAIO';
        $nro = '2900';
        $xCpl = 'KM 03';
        $xBairro = 'ENCRUZILHADA';
        $cMun = '4202305';
        $xMun = 'BIGUACU';
        $UF = 'SC';
        $CEP = '88165270';
        $cPais = '1058';
        $xPais = 'Brasil';
        $fone = '4832797100';
        $resp = $nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

//destinatário
        $CNPJ = '23401454000170';
        $CPF = '';
        $idEstrangeiro = '';
        $xNome = 'Chinnon Santos - Tecnologia e Assessoria em Softwares';
        $indIEDest = '1';
        $IE = '';
        $ISUF = '';
        $IM = '4128095';
        $email = 'nfe@chinnonsantos.com';
        $resp = $nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);

//Endereço do destinatário
        $xLgr = 'Av. gETULIO vARGAS';
        $nro = 's/n';
        $xCpl = '';
        $xBairro = 'CENTRO';
        $cMun = '4202305';
        $xMun = 'BIGUAÇU';
        $UF = 'SC';
        $CEP = '88161003';
        $cPais = '1058';
        $xPais = 'Brasil';
        $fone = '4899651410';
        $resp = $nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

//Identificação do local de retirada (se diferente do emitente)
//$CNPJ = '12345678901234';
//$CPF = '';
//$xLgr = 'Rua Vanish';
//$nro = '000';
//$xCpl = 'Ghost';
//$xBairro = 'Assombrado';
//$cMun = '3509502';
//$xMun = 'Campinas';
//$UF = 'SP';
//$resp = $nfe->tagretirada($CNPJ, $CPF, $xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF);
//Identificação do local de Entrega (se diferente do destinatário)
//$CNPJ = '12345678901234';
//$CPF = '';
//$xLgr = 'Viela Mixuruca';
//$nro = '2';
//$xCpl = 'Quabrada do malandro';
//$xBairro = 'Favela Mau Olhado';
//$cMun = '3509502';
//$xMun = 'Campinas';
//$UF = 'SP';
//$resp = $nfe->tagentrega($CNPJ, $CPF, $xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF);
//Identificação dos autorizados para fazer o download da NFe (somente versão 3.1)
        /* $aAut = array('23401454000170');
          foreach ($aAut as $aut) {
          if (strlen($aut) == 14) {
          $resp = $nfe->tagautXML($aut);
          } else {
          $resp = $nfe->tagautXML('', $aut);
          }
          } */

//produtos 1 (Limite da API é de 56 itens por Nota)
        $aP[] = array(
            'nItem' => 1,
            'cProd' => '15',
            'cEAN' => '97899072659522',
            'xProd' => 'Chopp Pilsen - Barril 30 Lts',
            'NCM' => '22030000',
            'NVE' => '',
            'CEST' => '', // Convênio ICMS 92/15
            'EXTIPI' => '',
            'CFOP' => '5101',
            'uCom' => 'Un',
            'qCom' => '4',
            'vUnCom' => '210.00',
            'vProd' => '840.00',
            'cEANTrib' => '',
            'uTrib' => 'Lt',
            'qTrib' => '120',
            'vUnTrib' => '7.00',
            'vFrete' => '',
            'vSeg' => '',
            'vDesc' => '',
            'vOutro' => '',
            'indTot' => '1',
            'xPed' => '16',
            'nItemPed' => '1',
            'nFCI' => '');
//produtos 2        
        /* $aP[] = array(
          'nItem' => 2,
          'cProd' => '56',
          'cEAN' => '7896030801822',
          'xProd' => 'Copo Personalizado Klima 300ml',
          'NCM' => '39241000',
          'NVE' => '',
          'CEST' => '',
          'EXTIPI' => '',
          'CFOP' => '5102',
          'uCom' => 'Cx',
          'qCom' => '2',
          'vUnCom' => '180.00',
          'vProd' => '360.00',
          'cEANTrib' => '',
          'uTrib' => 'Cx',
          'qTrib' => '2',
          'vUnTrib' => '180.00',
          'vFrete' => '',
          'vSeg' => '',
          'vDesc' => '',
          'vOutro' => '',
          'indTot' => '1',
          'xPed' => '16',
          'nItemPed' => '2',
          'nFCI' => '');
         */
        foreach ($aP as $prod) {
            
            $nItem = $prod['nItem'];
            $cProd = $prod['cProd'];
            $cEAN = $prod['cEAN'];
            $xProd = $prod['xProd'];
            $NCM = $prod['NCM'];
            $NVE = $prod['NVE'];
            $CEST = $prod['CEST'];
            $EXTIPI = $prod['EXTIPI'];
            $CFOP = $prod['CFOP'];
            $uCom = $prod['uCom'];
            $qCom = $prod['qCom'];
            $vUnCom = $prod['vUnCom'];
            $vProd = $prod['vProd'];
            $cEANTrib = $prod['cEANTrib'];
            $uTrib = $prod['uTrib'];
            $qTrib = $prod['qTrib'];
            $vUnTrib = $prod['vUnTrib'];
            $vFrete = $prod['vFrete'];
            $vSeg = $prod['vSeg'];
            $vDesc = $prod['vDesc'];
            $vOutro = $prod['vOutro'];
            $indTot = $prod['indTot'];
            $xPed = $prod['xPed'];
            $nItemPed = $prod['nItemPed'];
            $nFCI = $prod['nFCI'];
            $resp = $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $NVE, $CEST, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);
            
        }

// Informações adicionais na linha do Produto
        /* $nItem = 1; //produtos 1
          $vDesc = 'Barril 30 Litros Chopp Tipo Pilsen - Pedido Nº15';
          $resp = $nfe->taginfAdProd($nItem, $vDesc); */
        $nItem = 2; //produtos 2
        $vDesc = 'Caixa com 1000 unidades';
        $resp = $nfe->taginfAdProd($nItem, $vDesc);

//DI - Declaração de Importação
        /* $nItem = '1';
          $nDI = '234556786';
          $dDI = date('Y-m-d'); // Formato: “AAAA-MM-DD”
          $xLocDesemb = 'SANTOS';
          $UFDesemb = 'SP';
          $dDesemb = date('Y-m-d'); // Formato: “AAAA-MM-DD”
          $tpViaTransp = '1';
          $vAFRMM = '1.00';
          $tpIntermedio = '1';
          $CNPJ = '';
          $UFTerceiro = '';
          $cExportador = '111';
          $resp = $nfe->tagDI($nItem, $nDI, $dDI, $xLocDesemb, $UFDesemb, $dDesemb, $tpViaTransp, $vAFRMM, $tpIntermedio, $CNPJ, $UFTerceiro, $cExportador); */

//adi - Adições
        /* $nItem = '1';
          $nDI = '234556786';
          $nAdicao = '1';
          $nSeqAdicC = '123';
          $cFabricante = 'Klima Chopp';
          $vDescDI = '5.00';
          $nDraw = '9393939';
          $resp = $nfe->tagadi($nItem, $nDI, $nAdicao, $nSeqAdicC, $cFabricante, $vDescDI, $nDraw); */

//detExport
//$nItem = '2';
//$nDraw = '9393939';
//$exportInd = '1';
//$nRE = '2222';
//$chNFe = '1234567890123456789012345678901234';
//$qExport = '100';
//$resp = $nfe->tagdetExport($nItem, $nDraw, $exportInd, $nRE, $chNFe, $qExport);
//Impostos
        $nItem = 1; //produtos 1
        $vTotTrib = '449.90'; // 226.80 ICMS + 51.50 ICMSST + 50.40 IPI + 39.36 PIS + 81.84 CONFIS
        $resp = $nfe->tagimposto($nItem, $vTotTrib);
        $nItem = 2; //produtos 2
        $vTotTrib = '74.34'; // 61.20 ICMS + 2.34 PIS + 10.80 CONFIS
        $resp = $nfe->tagimposto($nItem, $vTotTrib);

//ICMS - Imposto sobre Circulação de Mercadorias e Serviços
        $nItem = 1; //produtos 1
        $orig = '0';
        $cst = '00'; // Tributado Integralmente
        $modBC = '3';
        $pRedBC = '';
        $vBC = '840.00'; // = $qTrib * $vUnTrib
        $pICMS = '27.00'; // Alíquota do Estado de GO p/ 'NCM 2203.00.00 - Cervejas de Malte, inclusive Chope'
        $vICMS = '226.80'; // = $vBC * ( $pICMS / 100 )
        $vICMSDeson = '';
        $motDesICMS = '';
        $modBCST = '';
        $pMVAST = '';
        $pRedBCST = '';
        $vBCST = '';
        $pICMSST = '';
        $vICMSST = '';
        $pDif = '';
        $vICMSDif = '';
        $vICMSOp = '';
        $vBCSTRet = '';
        $vICMSSTRet = '';
        $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);

        $nItem = 2; //produtos 2
        $orig = '0';
        $cst = '00';
        $modBC = '3';
        $pRedBC = '';
        $vBC = '360.00'; // = $qTrib * $vUnTrib
        $pICMS = '17.00'; // Alíquota Interna do Estado de GO 
        $vICMS = '61.20'; // = $vBC * ( $pICMS / 100 )
        $vICMSDeson = '';
        $motDesICMS = '';
        $modBCST = '';
        $pMVAST = '';
        $pRedBCST = '';
        $vBCST = '';
        $pICMSST = '';
        $vICMSST = '';
        $pDif = '';
        $vICMSDif = '';
        $vICMSOp = '';
        $vBCSTRet = '';
        $vICMSSTRet = '';
        $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);

//ICMS 10
        $nItem = 1; //produtos 1
        $orig = '0';
        $cst = '10'; // Tributada e com cobrança do ICMS por substituição tributária
        $modBC = '3';
        $pRedBC = '';
        $vBC = '840.00';
        $pICMS = '27.00'; // Alíquota do Estado de GO p/ 'NCM 2203.00.00 - Cervejas de Malte, inclusive Chope'
        $vICMS = '226.80'; // = $vBC * ( $pICMS / 100 )
        $vICMSDeson = '';
        $motDesICMS = '';
        $modBCST = '5'; // Calculo Por Pauta (valor)
        $pMVAST = '';
        $pRedBCST = '';
        $vBCST = '1030.80'; // Pauta do Chope Claro 1000ml em GO R$ 8,59 x 60 Litros
        $pICMSST = '27.00'; // GO para GO
        $vICMSST = '51.50'; // = (Valor da Pauta * Alíquota ICMS ST) - Valor ICMS Próprio
        $pDif = '';
        $vICMSDif = '';
        $vICMSOp = '';
        $vBCSTRet = '';
        $vICMSSTRet = '';
        $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);

        $vST = $vICMSST; // Total de ICMS ST
//ICMSPart - ICMS em Operações Interestaduais - CST 10
//$resp = $nfe->tagICMSPart($nItem, $orig, $cst, $modBC, $vBC, $pRedBC, $pICMS, $vICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pBCOp, $ufST);
//ICMSST - Tributação ICMS por Substituição Tributária (ST) - CST 40, 41, 50 e 51
//$resp = $nfe->tagICMSST($nItem, $orig, $cst, $vBCSTRet, $vICMSSTRet, $vBCSTDest, $vICMSSTDest);
//ICMSSN - Tributação ICMS pelo Simples Nacional - CST 30
//$resp = $nfe->tagICMSSN($nItem, $orig, $csosn, $modBC, $vBC, $pRedBC, $pICMS, $vICMS, $pCredSN, $vCredICMSSN, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $vBCSTRet, $vICMSSTRet);
//IPI - Imposto sobre Produto Industrializado
        $nItem = 1; //produtos 1
        $cst = '50'; // 50 - Saída Tributada (Código da Situação Tributária)
        $clEnq = '';
        $cnpjProd = '';
        $cSelo = '';
        $qSelo = '';
        $cEnq = '999';
        $vBC = '840.00';
        $pIPI = '6.00'; //Calculo por alíquota - 6% Alíquota GO.
        $qUnid = '';
        $vUnid = '';
        $vIPI = '50.40'; // = $vBC * ( $pIPI / 100 )
        $resp = $nfe->tagIPI($nItem, $cst, $clEnq, $cnpjProd, $cSelo, $qSelo, $cEnq, $vBC, $pIPI, $qUnid, $vUnid, $vIPI);

        $nItem = 2; //produtos 2
        $cst = '53'; // 53 - Saída Não-Tributada
        $clEnq = '';
        $cnpjProd = '';
        $cSelo = '';
        $qSelo = '';
        $cEnq = '999';
        $vBC = '';
        $pIPI = '';
        $qUnid = '';
        $vUnid = '';
        $vIPI = ''; // = $vBC * ( $pIPI / 100 )
        $resp = $nfe->tagIPI($nItem, $cst, $clEnq, $cnpjProd, $cSelo, $qSelo, $cEnq, $vBC, $pIPI, $qUnid, $vUnid, $vIPI);

//PIS - Programa de Integração Social
        $nItem = 1; //produtos 1
        $cst = '03'; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
        $vBC = '';
        $pPIS = '';
        $vPIS = '39.36';
        $qBCProd = '60.00';
        $vAliqProd = '0.3280';
        $resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);

        $nItem = 2; //produtos 2
        $cst = '01'; //Operação Tributável (base de cálculo = (valor da operação * alíquota normal) / 100
        $vBC = '180.00';
        $pPIS = '0.6500';
        $vPIS = '2.34';
        $qBCProd = '';
        $vAliqProd = '';
        $resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);

//PISST
//$resp = $nfe->tagPISST($nItem, $vBC, $pPIS, $qBCProd, $vAliqProd, $vPIS);
//COFINS - Contribuição para o Financiamento da Seguridade Social
        $nItem = 1; //produtos 1
        $cst = '03'; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
        $vBC = '';
        $pCOFINS = '';
        $vCOFINS = '81.84';
        $qBCProd = '60.00';
        $vAliqProd = '0.682';
        $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);

        $nItem = 2; //produtos 2
        $cst = '01'; //Operação Tributável (base de cálculo = (valor da operação * alíquota normal) / 100
        $vBC = '180.00';
        $pCOFINS = '3.00';
        $vCOFINS = '10.80';
        $qBCProd = '';
        $vAliqProd = '';
        $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);

//COFINSST
//$resp = $nfe->tagCOFINSST($nItem, $vBC, $pCOFINS, $qBCProd, $vAliqProd, $vCOFINS);
//II
//$resp = $nfe->tagII($nItem, $vBC, $vDespAdu, $vII, $vIOF);
//ICMSTot
//$resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);
//ISSQNTot
//$resp = $nfe->tagISSQNTot($vServ, $vBC, $vISS, $vPIS, $vCOFINS, $dCompet, $vDeducao, $vOutro, $vDescIncond, $vDescCond, $vISSRet, $cRegTrib);
//retTrib
//$resp = $nfe->tagretTrib($vRetPIS, $vRetCOFINS, $vRetCSLL, $vBCIRRF, $vIRRF, $vBCRetPrev, $vRetPrev);
//Inicialização de váriaveis não declaradas...
        $vII = isset($vII) ? $vII : 0;
        $vIPI = isset($vIPI) ? $vIPI : 0;
        $vIOF = isset($vIOF) ? $vIOF : 0;
        $vPIS = isset($vPIS) ? $vPIS : 0;
        $vCOFINS = isset($vCOFINS) ? $vCOFINS : 0;
        $vICMS = isset($vICMS) ? $vICMS : 0;
        $vBCST = isset($vBCST) ? $vBCST : 0;
        $vST = isset($vST) ? $vST : 0;
        $vISS = isset($vISS) ? $vISS : 0;

//total
        $vBC = '1200.00';
        $vICMS = '288.00';
        $vICMSDeson = '0.00';
        $vBCST = '1030.80';
        $vST = '51.50';
        $vProd = '1200.00';
        $vFrete = '0.00';
        $vSeg = '0.00';
        $vDesc = '0.00';
        $vII = '0.00';
        $vIPI = '50.40';
        $vPIS = '41.70';
        $vCOFINS = '92.64';
        $vOutro = '0.00';
        $vNF = number_format($vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI, 2, '.', '');
        $vTotTrib = number_format($vICMS + $vST + $vII + $vIPI + $vPIS + $vCOFINS + $vIOF + $vISS, 2, '.', '');
        $resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);

//frete
        $modFrete = '0'; //0=Por conta do emitente; 1=Por conta do destinatário/remetente; 2=Por conta de terceiros; 9=Sem Frete;
        $resp = $nfe->tagtransp($modFrete);

//transportadora
//$CNPJ = '';
//$CPF = '12345678901';
//$xNome = 'Ze da Carroca';
//$IE = '';
//$xEnder = 'Beco Escuro';
//$xMun = 'Campinas';
//$UF = 'SP';
//$resp = $nfe->tagtransporta($CNPJ, $CPF, $xNome, $IE, $xEnder, $xMun, $UF);
//valores retidos para transporte
//$vServ = '258,69'; //Valor do Serviço
//$vBCRet = '258,69'; //BC da Retenção do ICMS
//$pICMSRet = '10,00'; //Alíquota da Retenção
//$vICMSRet = '25,87'; //Valor do ICMS Retido
//$CFOP = '5352';
//$cMunFG = '3509502'; //Código do município de ocorrência do fato gerador do ICMS do transporte
//$resp = $nfe->tagretTransp($vServ, $vBCRet, $pICMSRet, $vICMSRet, $CFOP, $cMunFG);
//dados dos veiculos de transporte
//$placa = 'AAA1212';
//$UF = 'SP';
//$RNTC = '12345678';
//$resp = $nfe->tagveicTransp($placa, $UF, $RNTC);
//dados dos reboques
//$aReboque = array(
//    array('ZZQ9999', 'SP', '', '', ''),
//    array('QZQ2323', 'SP', '', '', '')
//);
//foreach ($aReboque as $reb) {
//    $placa = $reb[0];
//    $UF = $reb[1];
//    $RNTC = $reb[2];
//    $vagao = $reb[3];
//    $balsa = $reb[4];
//    //$resp = $nfe->tagreboque($placa, $UF, $RNTC, $vagao, $balsa);
//}
//Dados dos Volumes Transportados
        $aVol = array(
            array('4', 'Barris', '', '', '120.000', '120.000', ''),
            array('2', 'Volume', '', '', '10.000', '10.000', '')
        );
        foreach ($aVol as $vol) {
            $qVol = $vol[0]; //Quantidade de volumes transportados
            $esp = $vol[1]; //Espécie dos volumes transportados
            $marca = $vol[2]; //Marca dos volumes transportados
            $nVol = $vol[3]; //Numeração dos volume
            $pesoL = intval($vol[4]); //Kg do tipo Int, mesmo que no manual diz que pode ter 3 digitos verificador...
            $pesoB = intval($vol[5]); //...se colocar Float não vai passar na expressão regular do Schema. =\
            $aLacres = $vol[6];
            $resp = $nfe->tagvol($qVol, $esp, $marca, $nVol, $pesoL, $pesoB, $aLacres);
        }

//dados da fatura
        $nFat = '000035342';
        $vOrig = '1200.00';
        $vDesc = '';
        $vLiq = '1200.00';
        $resp = $nfe->tagfat($nFat, $vOrig, $vDesc, $vLiq);

//dados das duplicatas (Pagamentos)
        $aDup = array(
            array('35342-1', '2016-06-20', '300.00'),
            array('35342-2', '2016-07-20', '300.00'),
            array('35342-3', '2016-08-20', '300.00'),
            array('35342-4', '2016-09-20', '300.00')
        );
        foreach ($aDup as $dup) {
            $nDup = $dup[0]; //Código da Duplicata
            $dVenc = $dup[1]; //Vencimento
            $vDup = $dup[2]; // Valor
            $resp = $nfe->tagdup($nDup, $dVenc, $vDup);
        }


//*************************************************************
//Grupo obrigatório para a NFC-e. Não informar para a NF-e.
//$tPag = '03'; //01=Dinheiro 02=Cheque 03=Cartão de Crédito 04=Cartão de Débito 05=Crédito Loja 10=Vale Alimentação 11=Vale Refeição 12=Vale Presente 13=Vale Combustível 99=Outros
//$vPag = '1452,33';
//$resp = $nfe->tagpag($tPag, $vPag);
//se a operação for com cartão de crédito essa informação é obrigatória
//$CNPJ = '31551765000143'; //CNPJ da operadora de cartão
//$tBand = '01'; //01=Visa 02=Mastercard 03=American Express 04=Sorocred 99=Outros
//$cAut = 'AB254FC79001'; //número da autorização da tranzação
//$resp = $nfe->tagcard($CNPJ, $tBand, $cAut);
//**************************************************************
// Calculo de carga tributária similar ao IBPT - Lei 12.741/12
        $federal = number_format($vII + $vIPI + $vIOF + $vPIS + $vCOFINS, 2, ',', '.');
        $estadual = number_format($vICMS + $vST, 2, ',', '.');
        $municipal = number_format($vISS, 2, ',', '.');
        $totalT = number_format($federal + $estadual + $municipal, 2, ',', '.');
        $textoIBPT = "Valor Aprox. Tributos R$ {$totalT} - {$federal} Federal, {$estadual} Estadual e {$municipal} Municipal.";

//Informações Adicionais
//$infAdFisco = "SAIDA COM SUSPENSAO DO IPI CONFORME ART 29 DA LEI 10.637";
        $infAdFisco = "";
        $infCpl = "Pedido Nº16 - {$textoIBPT} ";
        $resp = $nfe->taginfAdic($infAdFisco, $infCpl);

//observações emitente
//$aObsC = array(
//    array('email','roberto@x.com.br'),
//    array('email','rodrigo@y.com.br'),
//    array('email','rogerio@w.com.br'));
//foreach ($aObsC as $obs) {
//    $xCampo = $obs[0];
//    $xTexto = $obs[1];
//    $resp = $nfe->tagobsCont($xCampo, $xTexto);
//}
//observações fisco
//$aObsF = array(
//    array('email','roberto@x.com.br'),
//    array('email','rodrigo@y.com.br'),
//    array('email','rogerio@w.com.br'));
//foreach ($aObsF as $obs) {
//    $xCampo = $obs[0];
//    $xTexto = $obs[1];
//    //$resp = $nfe->tagobsFisco($xCampo, $xTexto);
//}
//Dados do processo
//0=SEFAZ; 1=Justiça Federal; 2=Justiça Estadual; 3=Secex/RFB; 9=Outros
//$aProcRef = array(
//    array('nProc1','0'),
//    array('nProc2','1'),
//    array('nProc3','2'),
//    array('nProc4','3'),
//    array('nProc5','9')
//);
//foreach ($aProcRef as $proc) {
//    $nProc = $proc[0];
//    $indProc = $proc[1];
//    //$resp = $nfe->tagprocRef($nProc, $indProc);
//}
//dados exportação
//$UFSaidaPais = 'SP';
//$xLocExporta = 'Maritimo';
//$xLocDespacho = 'Porto Santos';
//$resp = $nfe->tagexporta($UFSaidaPais, $xLocExporta, $xLocDespacho);
//dados de compras
//$xNEmp = '';
//$xPed = '12345';
//$xCont = 'A342212';
//$resp = $nfe->tagcompra($xNEmp, $xPed, $xCont);
//dados da colheita de cana
//$safra = '2014';
//$ref = '01/2014';
//$resp = $nfe->tagcana($safra, $ref);
//$aForDia = array(
//    array('1', '100', '1400', '1000', '1400'),
//    array('2', '100', '1400', '1000', '1400'),
//    array('3', '100', '1400', '1000', '1400'),
//    array('4', '100', '1400', '1000', '1400'),
//    array('5', '100', '1400', '1000', '1400'),
//    array('6', '100', '1400', '1000', '1400'),
//    array('7', '100', '1400', '1000', '1400'),
//    array('8', '100', '1400', '1000', '1400'),
//    array('9', '100', '1400', '1000', '1400'),
//    array('10', '100', '1400', '1000', '1400'),
//    array('11', '100', '1400', '1000', '1400'),
//    array('12', '100', '1400', '1000', '1400'),
//    array('13', '100', '1400', '1000', '1400'),
///    array('14', '100', '1400', '1000', '1400')
//);
//foreach ($aForDia as $forDia) {
//    $dia = $forDia[0];
//    $qtde = $forDia[1];
//    $qTotMes = $forDia[2];
//    $qTotAnt = $forDia[3];
//    $qTotGer = $forDia[4];
//    //$resp = $nfe->tagforDia($dia, $qtde, $qTotMes, $qTotAnt, $qTotGer);
//}
//monta a NFe e retorna na tela
        $resp = $nfe->montaNFe();
        
        //print_r($resp);exit();
        if ($resp) {
            header('Content-type: text/xml; charset=UTF-8');
            $xml = $nfe->getXML();
            // $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
            $filename = "C:/xml/{$chave}-nfe.xml"; // Ambiente Windows
            file_put_contents($filename, $xml);
            chmod($filename, 0777);
            echo $xml;
        } else {
            header('Content-type: text/html; charset=UTF-8');
            foreach ($nfe->erros as $err) {
                echo 'tag: &lt;' . $err['tag'] . '&gt; ---- ' . $err['desc'] . '<br>';
            }
        }
        
     //// asssina   
// $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
        $filename = "C:/xml/{$chave}-nfe.xml"; // Ambiente Windows
        $xml = file_get_contents($filename);
        $xml = $nfeTools->assina($xml);  // troquei o nome da variavel pra pegar a classe correta conforme o exempo o nome tools
// $filename = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
        $filename = "C:/xml/assinadas/{$chave}-nfe.xml"; // Ambiente Windows
        file_put_contents($filename, $xml);
        chmod($filename, 0777);
        echo $chave;


/// valida xml

        $nfe = new NFePHP\NFe\ToolsNFe('NFePHP/config/config.json');
        $nfe->setModelo('55');


        $tpAmb = '2';
// $xml = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
        $xml = "C:/xml/assinadas/{$chave}-nfe.xml"; // Ambiente Windows

        if (!$nfe->validarXml($xml) || sizeof($nfeTools->errors)) {
            echo "<h3>Eita !?! Tem bicho na linha .... </h3>";
            foreach ($nfe->errors as $erro) {
                if (is_array($erro)) {
                    foreach ($erro as $err) {
                        echo "$err <br>";
                    }
                } else {
                    echo "$erro <br>";
                }
            }
            exit;
        }
        echo "NFe Valida !";

/// transmite

        $aResposta = array();

// $aXml = file_get_contents("/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"); // Ambiente Linux
        $aXml = file_get_contents("C:/xml/assinadas/{$chave}-nfe.xml"); // Ambiente Windows
        $idLote = '';
        $indSinc = '1';
        $flagZip = false;
        $retorno = $nfe->sefazEnviaLote($aXml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);
        echo '<br><br><pre>';
        echo htmlspecialchars($nfe->soapDebug);
        echo '</pre><br><br><pre>';
        print_r($aResposta);
        echo "</pre><br>";
    }
   
}
