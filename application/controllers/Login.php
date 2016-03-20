<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


 
class Login extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
       
    }
    
    public function index(){
        $this->load->view('html_header');
	$this->load->view('login');
	$this->load->view('html_footer');
    }

    

    public function logar(){
              	$usuario=$this->input->post('usuario');
	      	$senha=md5($this->input->post('senha'));
		$this->db->where('login',$usuario);
		$this->db->where('senha',$senha);
		$usuario_banco= $this->db->get('usuario')->result();
		if(count($usuario_banco)===1){
			$dados=array('login'=>$usuario_banco[0]->login,'logado'=>TRUE,
                            'id_usuario'=>$usuario_banco[0]->id_usuario
                            );
			$this->session->set_userdata($dados);
			$this->redirecionar();
		}
		else {
			$this->session->set_flashdata('msg', 'Acesso Não Autorizado.  Usuário ou Senha Incorretos!');
			redirect("login");
		}
		
        
    }
    
    public function deslogar(){
       		$this->session->sess_destroy();
		redirect("login");
        
    }
    
    private function redirecionar(){
        //echo "<pre>"; print_r($this->session->userdata()); exit();
        //exit('vou redirecio');
            redirect('home');
        
        
    }

       
}

?>
