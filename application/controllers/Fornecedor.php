<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//teste 16 04
class Fornecedor extends CI_Controller{
    
    public function __construct(){
	parent::__construct();
            if(!$this->session->userdata('logado')){
		redirect("login");
            }
        $this->load->model('fornecedor/Fornecedor_manager','Fornecedor_manager');
    }
    
    /***************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */
    
    public function carrega_view($view_corpo, $dados=null){
        $dados['active']='fornecedor';
        $this->load->view('html_header');
	$this->load->view('cabecalho');
	$this->load->view('menu_navegacao',$dados);
	$this->load->view($view_corpo,$dados);
	$this->load->view('rodape');
	$this->load->view('html_footer');
    }
    
    public function index(){
        $dados['fornecedores']=$this->Fornecedor_manager->get_fornecedores();
        $this->carrega_view('manter_fornecedores',$dados);    
		
    }
    
    public function novo_fornecedor(){
         $this->carrega_view('novo_fornecedor'); 
    }
    
    public function cadastrar(){
        $retorno=$this->Fornecedor_manager->cadastrar($this->input->post());
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Fornecedor Cadastrado com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Cadastrar Fornecedor!');
        }
        redirect('fornecedor');
    }
    
    public function editar($id_fornecedor){
        $dados['fornecedor']=  $this->Fornecedor_manager->get_fornecedor($id_fornecedor);
        $this->carrega_view('edicao_fornecedor',$dados);
    }
    
    public function gravar_alteracao(){
       $retorno=$this->Fornecedor_manager->gravar_alteracao($this->input->post());
       if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Fornecedor Alterado com Sucesso!');
        }
        redirect('fornecedor');
    }
    
    public function excluir($id_fornecedor){
        $retorno=$this->Fornecedor_manager->excluir($id_fornecedor);
        if($retorno==-1){
            $this->session->set_flashdata('status','danger');
            $msg="Este Fornecedor está relacionado a algum Produto.<br> Exclua o Produto Primeiro!";
            $this->session->set_flashdata('msg_confirm',$msg);
        }
        elseif($retorno==1){
           $this->session->set_flashdata('status','success');
           $this->session->set_flashdata('msg_confirm','Fornecedor Excluído com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir Fornecedor!');
        }
        redirect('fornecedor');
    }
    
}

