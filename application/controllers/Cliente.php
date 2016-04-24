<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Cliente extends CI_Controller{
    
    public function __construct(){
	parent::__construct();
            if(!$this->session->userdata('logado')){
		redirect("login");
            }
        $this->load->model('cliente/Cliente_manager','Cliente_manager');
    }
    
    /***************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */
    
    public function carrega_view($view_corpo, $dados=null){
        $dados['active']='cliente';
        $this->load->view('html_header');
	$this->load->view('cabecalho');
	$this->load->view('menu_navegacao',$dados);
	$this->load->view($view_corpo,$dados);
	$this->load->view('rodape');
	$this->load->view('html_footer');
    }
    
    public function index(){
        //$this->output->enable_profiler(TRUE);
        $dados['clientes']=$this->Cliente_manager->get_clientes();
        $this->carrega_view('manter_clientes',$dados);    
		
    }
    
    public function novo_cliente(){
         $this->carrega_view('novo_cliente'); 
    }
    
    public function cadastrar(){
        $retorno=$this->Cliente_manager->cadastrar($this->input->post());
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Cliente Cadastrado com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Cadastrar Cliente!');
        }
        redirect('cliente');
    }
    
    public function editar($id_cliente){
        $dados['cliente']=  $this->Cliente_manager->get_cliente($id_cliente);
        $this->carrega_view('edicao_cliente',$dados);
    }
    
    public function gravar_alteracao(){
       $retorno=$this->Cliente_manager->gravar_alteracao($this->input->post());
       if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Cliente Alterado com Sucesso!');
        }
        redirect('cliente');
    }
    
   public function excluir($id_cliente){
        $retorno=$this->Cliente_manager->excluir($id_cliente);
        if($retorno==-1){
            $this->session->set_flashdata('status','danger');
            $msg="Este Cliente está relacionado a algum Serviço.<br> Exclua o Serviço Primeiro!";
            $this->session->set_flashdata('msg_confirm',$msg);
        }
        elseif($retorno==1){
           $this->session->set_flashdata('status','success');
           $this->session->set_flashdata('msg_confirm','Cliente Excluído com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir Cliente!');
        }
        redirect('cliente');
    }
    
     public function detalhar_cliente_ajax($id_cliente){
         $dados['cliente']=  $this->Cliente_manager->get_cliente($id_cliente);
        $this->load->view('cliente_detalhado_ajax',  $dados);
    }
    
}

