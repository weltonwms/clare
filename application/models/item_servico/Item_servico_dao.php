<?php

class Item_servico_dao extends CI_Model {

    private $result_query; //array com resultado da query

    function __construct() {
        parent::__construct();
        $this->load->model('item_servico/Item_servico_model');
    }

    public function get_itens_servico($id_servico) {
        $this->iniciar_query();
        $this->db->where('id_servico', $id_servico);
        $this->db->order_by("id", "asc");
        $this->executar_query();
        $lista = $this->montar_itens_servico();
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

    private function montar_itens_servico() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_item_servico($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_item_servico($objeto_banco) {
        $item_servico = new $this->Item_servico_model();
        $item_servico->set_id($objeto_banco->id);
        $item_servico->set_id_servico($objeto_banco->id_servico);
        $item_servico->set_id_produto($objeto_banco->id_produto);
        $item_servico->set_qtd_produto($objeto_banco->qtd_produto);
        $item_servico->set_valor_final($objeto_banco->valor_final);
        $item_servico->set_valor_fornecedor($objeto_banco->valor_fornecedor);
        $item_servico->set_descricao($objeto_banco->descricao);

        return $item_servico;
    }

    private function iniciar_query() {
        $this->db->select("*");
        $this->db->from("item_servico");
    }

    private function executar_query() {
        $this->result_query = $this->db->get()->result();
    }

    public function get_itens_servico_vazio() {
        return array();
    }

}
