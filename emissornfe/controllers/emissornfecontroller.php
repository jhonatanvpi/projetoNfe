<?php

class emissornfecontroller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('access');
    }

    public function index() {
        $this->load->view('emissornfeview');
    }
    
    
    
    public function emitirNfe() {
                               
        $this->load->model('emissornfemodel');

        $retorno = $this->emissornfemodel->emitirNfe();

        echo json_encode($retorno);
    }
    
    
   
     
    public function salvar() {
              
                
        $idEmpresa       = $this->input->POST('idEmpresa');
        $idFilial        = $this->input->POST('idFilial');
        $idBanco         = $this->input->POST('idBanco');
        $agencia         = $this->input->POST('agencia');
        $nome            = $this->input->POST('nome');
        $endereco        = $this->input->POST('endereco');
        $cep             = $this->input->POST('cep');
        $cidade          = $this->input->POST('cidade');
        $bairro          = $this->input->POST('bairro');
        $telefone        = $this->input->POST('telefone');
        $nomeGerente     = $this->input->POST('nomeGerente');
        $pessoaContato   = $this->input->POST('pessoaContato');
        $email           = $this->input->POST('email');
        $observacao      = $this->input->POST('observacao');
        
        
                        
        $this->load->model('cadastroagenciamodel');

        $retorno = $this->cadastroagenciamodel->salvar($idEmpresa, $idFilial, $idBanco, $agencia, $nome, $endereco, $cep, $cidade, $bairro, $telefone, $nomeGerente, $pessoaContato, $email, $observacao);

        echo json_encode($retorno);
    }
      
    
    public function salvarAnexoXml() {
        
        $this->load->library('session');

        $usuario = $this->session->userdata('usuario');
        $arq = "";
        
        if (isset($_FILES['anexo1'])) {
            $arq = $_FILES['anexo1'];
            //print_r($_FILES['anexo1']);exit();
            $pogDo = rand(5, 99999999);
            parse_str($pogDo);
            $data = date("Y-m-d-H-i-s");
            parse_str($data);

            $folder = UPLOADSSERVICEDESK_PATH_XML . '/';
            //print_r($folder);exit();
            
            $config = array();
            $config['upload_path'] = $folder;
            $config['file_name'] = $data . $pogDo;
            $config['allowed_types'] = 'gif|jpg|png|bmp|GIF|JPG|PNG|BMP|doc|DOC|docx|DOCX|pdf|PDF|xls|XLS|xlsx|XLSX|txt|TXT|rar|RAR|zip|ZIP|xml|XML';
            $config['max_size'] = '100000';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!is_dir($folder)) {
                mkdir($folder);
            }
            
            $this->upload->do_upload('anexo1');
            
            $xml = $this->upload->data();
            //print_r($xml);exit();
            //print_r($foto);exit();
            //move_uploaded_file($_FILES['anexo1']['tmp_name'], $folder . $_FILES['anexo1']['name']);

            $ret = $this->upload->display_errors();
             
            
        }
        
        $anexo = $xml['full_path'];

        echo $anexo;
        
    }
    
    
    public function xmlParser(){
       
        $enderecoXml      = $this->input->POST('enderecoAnexo');
        //print_r($enderecoXml);exit();
        
        $this->load->model('emissornfemodel');

        $retorno = $this->emissornfemodel->xmlParser($enderecoXml);

        echo json_encode($retorno);    
    } 
    
 
    public function carregarEmpresas() {

        $this->load->model('emissornfemodel');

        $retorno = $this->emissornfemodel->carregarEmpresas();

        echo json_encode($retorno);
    }
    
    
    public function getGrid() {
        
        $draw = $this->input->POST('draw');
        $CNPJFiltro = $this->input->POST('CNPJFiltro');
        $dataInicialFiltro = $this->input->POST('dataInicialFiltro');
        $dataFinalFiltro = $this->input->POST('dataFinalFiltro');
        
        $this->load->model('emissornfemodel');
        $retorno = $this->emissornfemodel->getGrid($draw,$CNPJFiltro,
                                                   $dataInicialFiltro,
                                                   $dataFinalFiltro);
        echo json_encode($retorno);
            
    }
    
    
    public function selecionaGrid(){
        
        $ID = $this->input->POST('ID');
        $destCNPJ = $this->input->POST('destCNPJ');
        
        $this->load->model('emissornfemodel');
        
        $retorno = $this->emissornfemodel->selecionaGrid($ID,$destCNPJ);
        
        echo ($retorno);
                
    }

    

}
