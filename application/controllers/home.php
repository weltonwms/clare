<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('session_id') || !$this->session->userdata('logado') ){
			redirect("login");
		}
                
	}
	
		
	public function index()
	{
		$this->load->view('html_header');
		$this->load->view('cabecalho');
		$this->load->view('menu_navegacao');
		$this->load->view('conteudo_teste');
		$this->load->view('rodape');
		$this->load->view('html_footer');		
		
	}
        
        public function teste(){
            $this->load->model('servico/Servico_manager','x');
            $skips=array('id_servico','tipo');
            $post=array('data'=>'09/09/2013','id_cliente'=>'6');
            $this->x->set_servico($post,$skips);
        }
        
       
        
        
        
       
	
	
					
}
