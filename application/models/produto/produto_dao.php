<?php

class Produto_dao extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('produto/Produto_model');
    }

    public function get_produtos() {
        $lista = array();
        $this->db->order_by("nome", "asc");
        $produtos_banco = $this->db->get('produto')->result();
        if (count($produtos_banco) > 0) {
            foreach ($produtos_banco as $produto) {
                $lista[] = $this->get_produto($produto->id_produto);
            }
        }
        return $lista;
    }

    public function get_produto($id_produto) {
        $this->db->where('id_produto', $id_produto);
        $produto_banco = $this->db->get('produto')->result();
        if (count($produto_banco) > 0) {
            $produto = new $this->Produto_model();
            $produto->set_id_produto($produto_banco[0]->id_produto);
            $produto->set_nome($produto_banco[0]->nome);
           
            $produto->set_id_fornecedor($produto_banco[0]->id_fornecedor);
            
            return $produto;
        }
        return;
    }

}

