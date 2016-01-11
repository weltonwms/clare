<?php

class Produto_composite_dao extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->model('produto/Produto_composite');
        $this->load->model('produto/Produto_dao');
        $this->load->model('fornecedor/Fornecedor_dao');
        
    }
    
     public function get_produtos_composite() {
         $lista = array();
       
        $this->db->order_by("nome", "asc");
        $produtos_banco = $this->db->get('produto')->result();
        if (count($produtos_banco) > 0) {
           foreach ($produtos_banco as $produto) {
                $lista[] = $this->get_produto_composite($produto->id_produto);
            }

           
        }
         return $lista;
    }
    
     
    
    

    public function get_produto_composite($id_produto) {
        $this->db->where('id_produto', $id_produto);
        $produto_banco = $this->db->get('produto')->result();
        if (count($produto_banco) > 0) {
            $produto = new $this->Produto_composite();
            $produto->set_produto($this->Produto_dao->get_produto($produto_banco[0]->id_produto));
            $produto->set_fornecedor($this->Fornecedor_dao->get_fornecedor($produto_banco[0]->id_fornecedor));
                      
            return $produto;
        }
        return;
    }
}


