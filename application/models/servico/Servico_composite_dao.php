<?php

class Servico_composite_dao extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('servico/Servico_composite');
        $this->load->model('servico/Servico_dao');
        $this->load->model('cliente/Cliente_dao');
        $this->load->model('item_servico/Item_servico_dao');
    }

    public function get_servicos_composite() {
        $lista = array();

        $this->db->order_by("id_servico", "desc");
        $servicos_banco = $this->db->get('servico')->result();
        if (count($servicos_banco) > 0) {
            foreach ($servicos_banco as $servico) {
                $lista[] = $this->get_servico_composite($servico->id_servico);
            }
        }
        return $lista;
    }

    public function get_servico_composite($id_servico) {
        $servico_banco= array();
        if ($id_servico):
            $this->db->where('id_servico', $id_servico);
            $servico_banco = $this->db->get('servico')->result();
        endif;
        $servico = new $this->Servico_composite();
        if (count($servico_banco) > 0) {

            $servico->set_servico($this->Servico_dao->get_servico($servico_banco[0]->id_servico));
            $servico->set_cliente($this->Cliente_dao->get_cliente($servico_banco[0]->id_cliente));
            $servico->set_itens_servico($this->Item_servico_dao->get_itens_servico($servico_banco[0]->id_servico));
        } else {
            $servico->set_servico($this->Servico_dao->get_servico_vazio());
            $servico->set_cliente($this->Cliente_dao->get_cliente_vazio());
            $servico->set_itens_servico($this->Item_servico_dao->get_itens_servico_vazio());
        }
        return $servico;
    }

}

