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
        $this->carrega_view('cliente/manter_clientes',$dados);    
		
    }
    /*
    public function novo_cliente(){
         $this->carrega_view('cliente/novo_cliente'); 
    }
     * 
     */
    
    public function salvar_cliente(){
        $retorno=$this->Cliente_manager->salvar($this->input->post());
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Cliente Salvo com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Salvar Cliente!');
        }
        redirect('cliente');
    }
    
    public function editar($id_cliente=null){
        $dados['cliente']=  $this->Cliente_manager->get_cliente($id_cliente);
        $this->carrega_view('cliente/edicao_cliente',$dados);
    }
    
    public function excluir($id_cliente){
        $retorno=$this->Cliente_manager->excluir($id_cliente);
        
        if($retorno===-1){
            $this->session->set_flashdata('status','danger');
            $msg="Este Cliente está relacionado a algum Serviço.<br> Exclua o Serviço Primeiro!";
            $this->session->set_flashdata('msg_confirm',$msg);
        }
        elseif($retorno==TRUE){
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
        $this->load->view('cliente/cliente_detalhado_ajax',  $dados);
    }
    public function teste1(){
        $this->load->model('servico/Servico_model');
        $atributos=  $this->Servico_model->get_atributos();
        echo "<pre>"; print_r($atributos); echo "<pre>";
        
        end($atributos);
        reset($atributos);
        echo key($atributos);
    }
    
    public function teste2(){
        $this->load->model('cliente/Cliente_dao');
        echo "<pre>";
        print_r($this->Cliente_dao->get_clientes(7));
    }
    
}

