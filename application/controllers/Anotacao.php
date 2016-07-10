<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Anotacao extends CI_Controller{
    
    public function __construct(){
	parent::__construct();
            if(!$this->session->userdata('logado')){
		redirect("login");
            }
        $this->load->model('anotacao/Anotacao_manager');
    }
    
    /***************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */
    
    public function carrega_view($view_corpo, $dados=null){
        $dados['active']='anotacao';
        $this->load->view('html_header');
	$this->load->view('cabecalho');
	$this->load->view('menu_navegacao',$dados);
	$this->load->view($view_corpo,$dados);
	$this->load->view('rodape');
	$this->load->view('html_footer');
    }
    
    public function index(){
        //$this->output->enable_profiler(TRUE);
        $dados['anotacoes']=$this->Anotacao_manager->get_anotacoes();
        //echo "<pre>"; print_r($dados); exit();
        $this->carrega_view('anotacao/manter_anotacoes',$dados);    
		
    }
    
    public function salvar(){
        
        $retorno=$this->Anotacao_manager->salvar($this->input->post());
        
        if($retorno['status']>0){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm',"{$retorno['acao_executada']} com Sucesso!");
        }
        elseif($retorno['acao_executada']!='alteracao' && $retorno['status']==0){
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Salvar!');
        }
        redirect(base_url('anotacao'));
    }
    
    public function editar($id_anotacao=null){
        
        $this->load->model('fornecedor/Fornecedor_manager');
       
        $dados['fornecedores']=  $this->Fornecedor_manager->get_fornecedores();
        $dados['anotacao']=$this->Anotacao_manager->get_anotacao($id_anotacao);
        $this->carrega_view('anotacao/edicao_anotacao',$dados);
    }
    
    
    
    public function excluir($id_anotacao){
        $retorno=$this->Anotacao_manager->excluir($id_anotacao);
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Anotação Excluída com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir!');
        }
        redirect(base_url('anotacao'));
    }
    
    
    
    
}

