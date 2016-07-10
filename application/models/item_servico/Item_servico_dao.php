<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Item_servico_dao extends Generic_dao {

    function __construct() {
        parent::__construct();
        $this->load->model('item_servico/Item_servico_model');
    }

    public function get_itens_servico($id_servico) {
        $this->iniciar_query();
        $this->db->where('id_servico', $id_servico);
        $this->db->order_by("id_item", "asc");
        $this->executar_query();
        $lista = $this->montar_itens_servico();
        return $lista;
    }

    public function get_item_servico($id_item_servico) {
        $this->db->where('id_item', $id_item_servico);
        $item_servico_banco = $this->db->get('item_servico')->result();
        if (count($item_servico_banco) > 0) {
            $item_servico = new $this->Item_servico_model();
            $this->set_atributos($item_servico_banco[0], $id_item_servico);
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
        $this->set_atributos($objeto_banco, $item_servico);
        return $item_servico;
    }

    protected function iniciar_query() {
        $this->db->select("*");
        $this->db->from("item_servico");
    }

    

    public function get_itens_servico_vazio() {
        return array();
    }
    
    

    protected function get_componentes_composite() {
        
    }

}
