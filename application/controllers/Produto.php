<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Produto extends CI_Controller{
    
    public function __construct(){
	parent::__construct();
            if(!$this->session->userdata('logado')){
		redirect("login");
            }
        $this->load->model('produto/Produto_manager','Produto_manager');
    }
    
    /***************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */
    
    public function carrega_view($view_corpo, $dados=null){
        $dados['active']='produto';
        $this->load->view('html_header');
	$this->load->view('cabecalho');
	$this->load->view('menu_navegacao',$dados);
	$this->load->view($view_corpo,$dados);
	$this->load->view('rodape');
	$this->load->view('html_footer');
    }
    
    public function index(){
        $dados['produtos']=$this->Produto_manager->get_produtos();
        $this->carrega_view('manter_produtos',$dados);    
		
    }
    
    public function novo_produto(){
        $this->load->model('fornecedor/Fornecedor_manager','Fornecedor_manager');
        $dados['fornecedores']=$this->Fornecedor_manager->get_fornecedores();
        $this->carrega_view('novo_produto',$dados); 
    }
    
    public function cadastrar(){
        $retorno=$this->Produto_manager->cadastrar($this->input->post());
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Produto Cadastrado com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Cadastrar Produto!');
        }
        redirect('produto');
    }
    
    public function editar($id_produto){
        $this->load->model('fornecedor/Fornecedor_manager','Fornecedor_manager');
        $dados['fornecedores']=$this->Fornecedor_manager->get_fornecedores();
        $dados['produto']=  $this->Produto_manager->get_produto($id_produto);
        $this->carrega_view('edicao_produto',$dados);
    }
    
    public function gravar_alteracao(){
       $retorno=$this->Produto_manager->gravar_alteracao($this->input->post());
       if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Produto Alterado com Sucesso!');
        }
        redirect('produto');
    }
    
    public function excluir($id_produto){
        $retorno=$this->Produto_manager->excluir($id_produto);
        
        if($retorno==-1){
            $this->session->set_flashdata('status','danger');
            $msg="Este Produto está relacionado a algum Serviço.<br> Exclua o Produto do Serviço Primeiro!";
            $this->session->set_flashdata('msg_confirm',$msg); 
        }
        elseif($retorno==1){
           $this->session->set_flashdata('status','success');
           $this->session->set_flashdata('msg_confirm','Produto Excluído com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir Produto!');
        }
        redirect('produto');
    }
    
    public function teste(){
        $this->load->model('fornecedor/Fornecedor_model','x');
        $this->x->is_relacionado_a_produto(3);
    }
    
}

