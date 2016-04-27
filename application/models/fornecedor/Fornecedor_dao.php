<?php

class Fornecedor_dao extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('fornecedor/Fornecedor_model', 'Fornecedor_model');
    }

    public function get_fornecedores($chave_array_igual_id = null) {
        $this->db->order_by("empresa", "asc");
        $fornecedores_banco = $this->db->get('fornecedor')->result();
        if (count($fornecedores_banco) > 0) {
            $lista = array();
            foreach ($fornecedores_banco as $fornecedor) {
                if ($chave_array_igual_id) {
                    $lista[$fornecedor->id_fornecedor] = $this->get_fornecedor($fornecedor->id_fornecedor);
                } else {
                    $lista[] = $this->get_fornecedor($fornecedor->id_fornecedor);
                }
            }

            return $lista;
        }
        return;
    }

    public function get_fornecedor($id_fornecedor) {
        $this->db->where('id_fornecedor', $id_fornecedor);
        $fornecedor_banco = $this->db->get('fornecedor')->result();
        if (count($fornecedor_banco) == 1) {
            $fornecedor = new $this->Fornecedor_model();
            $this->set_atributos($fornecedor_banco[0], $fornecedor);
            
            return $fornecedor;
        }
        return;
    }
    
     private function set_atributos($objeto_banco, $objeto) {

        $attr = $objeto->get_atributos();
        foreach ($attr as $key => $valor):

            $metodo = "set_$key";
            if(method_exists( $objeto ,$metodo )):
            $objeto->$metodo(isset($objeto_banco->$key) ? $objeto_banco->$key : null);
            endif;
        endforeach;
    }

}


