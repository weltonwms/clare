<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Servico extends CI_Controller{
    
    public function __construct(){
	parent::__construct();
            if(!$this->session->userdata('logado')){
		redirect("login");
            }
        $this->load->model('servico/Servico_manager','Servico_manager');
    }
    
    /***************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */
    
    public function carrega_view($view_corpo, $dados=null){
        $dados['active']='servico';
        $this->load->view('html_header');
	$this->load->view('cabecalho');
	$this->load->view('menu_navegacao',$dados);
	$this->load->view($view_corpo,$dados);
	$this->load->view('rodape');
	$this->load->view('html_footer');
    }
    
    public function index(){
        $dados['servicos']=$this->Servico_manager->get_servicos();
        $this->carrega_view('manter_servicos',$dados);    
		
    }
    
    
    
    public function salvar_servico(){
        
        $retorno=$this->Servico_manager->salvar_servico($this->input->post());
        
        if($retorno['status']>0){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm',"{$retorno['acao_executada']} com Sucesso!");
        }
        elseif($retorno['acao_executada']!='alteracao' && $retorno['status']==0){
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Salvar Serviço!');
        }
        redirect('servico');
    }
    
    public function editar($id_servico=null){
        
        $this->load->model('cliente/Cliente_manager','Cliente_manager');
        $this->load->model('produto/Produto_manager','Produto_manager');
        $dados['clientes']=  $this->Cliente_manager->get_clientes();
        $dados['produtos']=  $this->Produto_manager->get_produtos();
        $dados['servico']=$this->Servico_manager->get_servico($id_servico);
        $this->carrega_view('edicao_servico',$dados);
    }
    
    
    
    public function excluir($id_servico){
        $retorno=$this->Servico_manager->excluir($id_servico);
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Serviço Excluído com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir Serviço!');
        }
        redirect('servico');
    }
    
    public function imprimir($id_servico){
        $imprimir_total=$this->input->get('imprimir_total')==""?1:$this->input->get('imprimir_total');
        $dados['servico']=$this->Servico_manager->get_servico($id_servico);
        $dados['imprimir_total']=  $imprimir_total;
        $html=$this->load->view('impressao_servico',  $dados,TRUE);
        $this->load->library('pdf');
        $this->pdf->createPDF($html,'relat');
    }
    
    public function manter_itens_servico(){
        //echo "<pre>"; print_r($this->input->post()); exit();
        $retorno=$this->Servico_manager->manter_itens_servico($this->input->post());
        $id_servico=$retorno['id_servico'];
        //echo "<pre>"; print_r($retorno); exit();
        if($retorno['status']){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Serviço Salvo com Sucesso!');
        }
        elseif($retorno['acao_executada']!='alteracao' && !$retorno['status']){
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Salvar Serviço!');
        }
        redirect("servico/editar/$id_servico");
        
        
    }
    
     public function excluir_item_servico($id_item_servico, $id_servico){
        $retorno=$this->Servico_manager->excluir_item_servico($id_item_servico);
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Item de Serviço Excluído com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir Item de Serviço!');
        }
         redirect("servico/editar/$id_servico");
    }
    
    public function clonar(){
        $retorno=$this->Servico_manager->clonar($this->input->post());
         if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Serviço Clonado com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Clonar o Serviço!');
        }
        redirect('servico');
    }
    
    public function executar_servico($id_servico){
        $retorno=$this->Servico_manager->executar_servico($id_servico);
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Estado Mudado com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Mudar o Estado!');
        }
        redirect('servico');
    }

    public function detalhar_servico_ajax($id_servico){
        $dados['servico']=$this->Servico_manager->get_servico($id_servico);
        $this->load->view('servico_detalhado_ajax',  $dados);
    }
    
}

