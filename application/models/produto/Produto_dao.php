<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Produto_dao extends Generic_dao {

    

    function __construct() {
        parent::__construct();
        $this->load->model('produto/Produto_model');
        $this->load->model('produto/Produto_composite');
        //$this->load->model('fornecedor/Fornecedor_dao');
        $this->load->model('fornecedor/Fornecedor_model');
    }

    public function get_produtos_composite() {
        return $this->get_objetos();
        
    }

    public function get_produto_composite($id_produto) {
     return $this->get_objeto($id_produto, 'id_produto');
        
    }

    

    protected function iniciar_query() {
        $this->db->select("*");
        $this->db->from("produto p");
        $this->db->join("fornecedor f", "p.id_fornecedor=f.id_fornecedor", "left");
    }


    protected function get_componentes_composite()
    {
       return array(
           new Produto_composite(),
           new Produto_model(),
           new Fornecedor_model()
       );
        
    }

}
