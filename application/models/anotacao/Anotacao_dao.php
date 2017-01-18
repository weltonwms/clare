<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Anotacao_dao extends Generic_dao {

   

    function __construct() {
        parent::__construct();
        
        $this->load->model('anotacao/Anotacao_model');
        $this->load->model('anotacao/Anotacao_composite');
        $this->load->model('fornecedor/Fornecedor_dao');
         
    }
   
    public function get_anotacoes_composite() {

       return $this->get_objetos();
    }

    public function get_anotacao_composite($id) {
       return $this->get_objeto($id,"id_anotacao");
    }

    protected function iniciar_query() {
        $this->db->select("*");
        $this->db->from("anotacao a");
        $this->db->join("fornecedor f", "a.id_fornecedor=f.id_fornecedor", "left");
    }
  
    protected function get_componentes_composite() {

        $componentes = array(
            new Anotacao_composite(),
            new Anotacao_model(),
            new Fornecedor_model()
        );
        return $componentes;
    }

}
