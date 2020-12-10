<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Boleto extends CI_Controller{
    
    public function __construct(){
	parent::__construct();
            if(!$this->session->userdata('logado')){
		        redirect("login");
            }
       $this->load->model('boleto/Boleto_manager','Boleto_manager');
    }
    
    /***************************************************************************
     * O metodo carrega_view() carrega os arquivos php que estao na passta view
     * e representa o layout. Recebe como parâmetro obrigatório o nome do arquivo
     * do corpo que será carregado e opcionamente um array de dados para 
     * introduzir na visão do corpo
     * *************************************************************************
     */
    
    public function carrega_view($view_corpo, $dados=null){
        $dados['active']='boleto';
        $this->load->view('html_header');
	    $this->load->view('cabecalho');
	    $this->load->view('menu_navegacao',$dados);
	    $this->load->view($view_corpo,$dados);
	    $this->load->view('rodape');
	    $this->load->view('html_footer');
    }
    
    public function index(){
        
       $dados=[
           "items"=>$this->Boleto_manager->getBoletos()
       ];
       
       //echo "<pre>";       print_r($dados); exit();
        $this->carrega_view('boleto/manter_boleto',$dados);    
		
    }
    
    public function save(){
        $retorno=$this->Boleto_manager->save($this->input->post());
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Boleto Salvo com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Salvar Boleto!');
        }
        $this->session->set_flashdata('scrollTop',$this->input->post('scrollTop'));
        redirect('boleto');
    }
    
    public function excluir($id_boleto){
        $retorno=$this->Boleto_manager->delete($id_boleto);
        
        if($retorno){
           $this->session->set_flashdata('status','success');
           $this->session->set_flashdata('msg_confirm','Boleto Excluído com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi possível Excluir Boleto!');
        }
        redirect('boleto');
    }
    
    public function alterarEstado($id_boleto){
         $retorno=$this->Boleto_manager->alterarEstado($id_boleto,2);
        if($retorno){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('msg_confirm','Estado alterado com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Alterar Estado!');
        }
        
        redirect('boleto');
    }


    public function teste(){
        
    }
    
   
    
    public function createBath(){
        $post= $this->input->post();
        $retorno= $this->Boleto_manager->createBath($post);
        echo json_encode($retorno);
    }
    
    public function createAjax(){
        $retorno=$this->Boleto_manager->create2($this->input->post());
        echo json_encode($retorno);
    }
    
    public function editAjax(){
        //print_r($this->input->post());
        $this->db->where('id_boleto', $this->input->post('id_boleto'));
        echo $this->db->update('boleto', $this->input->post());
    }
    
    public function excluirAjax($id_boleto){
         $retorno=$this->Boleto_manager->delete($id_boleto);
        echo json_encode($retorno);
    }
    
    public function getBoletosAjax($id_servico){
        $retorno=$this->Boleto_manager->getBoletosByServico($id_servico);
        echo json_encode($retorno);
    }
    
   
    
   
    
    
}

