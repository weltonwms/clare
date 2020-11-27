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
            $this->session->set_flashdata('msg_confirm','Cliente Salvo com Sucesso!');
        }
        else{
            $this->session->set_flashdata('status','danger');
            $this->session->set_flashdata('msg_confirm','Não foi Possível Salvar Cliente!');
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
        $dt1="2019-09-09";
        $dt2="2020-09-08";
        
        if($dt1 > $dt2){
            echo "$dt1 eh maior que $dt2";
        }else if($dt1===$dt2){
            echo "$dt1 eh igual a $dt2";
        }
        else{
            echo "$dt1 eh menor que $dt2";
        }
        
         $h=date("Y-m-d");
         echo "<br><br>Hoje é: ".$h;
    }
    
   
    
   
    
    
}

