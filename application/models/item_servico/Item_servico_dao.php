<?php

class Item_servico_dao extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('item_servico/Item_servico_model');
    }

    public function get_itens_servico($id_servico) {
        $lista = array();
        $this->db->where('id_servico', $id_servico);
        $this->db->order_by("id", "asc");
        $itens_servico_banco = $this->db->get('item_servico')->result();
        if (count($itens_servico_banco) > 0) {
            foreach ($itens_servico_banco as $item_servico) {
                $lista[] = $this->get_item_servico($item_servico->id);
            }
        }
        return $lista;
    }

    public function get_item_servico($id_item_servico) {
        $this->db->where('id', $id_item_servico);
        $item_servico_banco = $this->db->get('item_servico')->result();
        if (count($item_servico_banco) > 0) {
            $item_servico = new $this->Item_servico_model();
            $item_servico->set_id($item_servico_banco[0]->id);
            $item_servico->set_id_servico($item_servico_banco[0]->id_servico);
            $item_servico->set_id_produto($item_servico_banco[0]->id_produto);
            $item_servico->set_qtd_produto($item_servico_banco[0]->qtd_produto);
            $item_servico->set_valor_final($item_servico_banco[0]->valor_final);
            $item_servico->set_valor_fornecedor($item_servico_banco[0]->valor_fornecedor);
            $item_servico->set_descricao($item_servico_banco[0]->descricao);
            
            return $item_servico;
        }
        return;
    }
    
    public function get_itens_servico_vazio(){
        return array();
    }

}

