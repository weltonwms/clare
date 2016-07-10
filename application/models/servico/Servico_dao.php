<?php
include_once( APPPATH . 'models/generic/Generic_dao.php');
class Servico_dao extends Generic_dao {

    function __construct() {
        parent::__construct();
        $this->load->model('servico/Servico_model');
        $this->load->model('servico/Servico_composite');
        $this->load->model('cliente/Cliente_model');
        /*
        $this->load->model('cliente/Cliente_dao');
        $this->load->model('item_servico/Item_servico_dao');
         * 
         */
    }

    public function get_servicos() {

        $lista = array();
        $this->db->order_by("id_servico", "asc");
        $servicos_banco = $this->db->get('servico')->result();
        if (count($servicos_banco) > 0) {
            foreach ($servicos_banco as $servico) {
                $lista[] = $this->get_servico($servico->id_servico);
            }
        }
        return $lista;
    }

    public function get_servico($id_servico) {
        $this->db->where('id_servico', $id_servico);
        $servico_banco = $this->db->get('servico')->result();
        if (count($servico_banco) > 0) {
            $servico = new $this->Servico_model();
            $this->set_atributos($servico_banco[0], $servico);
            return $servico;
        }
        return;
    }

    public function get_servico_vazio() {
        return new $this->Servico_model();
    }

    public function get_servicos_composite() {
        return $this->get_objetos_composite();
    }

    public function get_servico_composite($id_servico) {
        return $this->get_objeto_composite($id_servico, "id_servico");
       
    }

    protected function iniciar_query() {
        $this->db->select("*");
        $this->db->from("servico s");
        $this->db->join("cliente c", "s.id_cliente=c.id_cliente", "left");
    }
     
    protected function get_componentes_composite() {
        $componentes = array(
            new Servico_composite(),
            new Servico_model(),
            new Cliente_model()
        );
        return $componentes;
    }

}
