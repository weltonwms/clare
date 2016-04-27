<?php

class Cliente_dao extends CI_Model {

    private $result_query; //array com resultado da query

    function __construct() {
        parent::__construct();
        $this->load->model('cliente/Cliente_model', 'Cliente_model');
    }

    public function get_clientes() {
        $this->iniciar_query();
        $this->db->order_by("nome", "asc");
        $this->executar_query();
        $lista = $this->montar_clientes();
        return $lista;
    }

    public function get_cliente($id_cliente) {
        $this->iniciar_query();
        $this->db->where('id_cliente', $id_cliente);
        $this->executar_query();
        return $this->montar_cliente($this->result_query[0]);
    }

    public function get_cliente_vazio() {
        return new $this->Cliente_model();
    }

    private function iniciar_query() {
        $this->db->select("*");
        $this->db->from("cliente");
    }

    private function executar_query() {
        $this->result_query = $this->db->get()->result();
    }

    private function montar_clientes() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_cliente($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_cliente($objeto_banco) {
        $objeto_cliente_model = new $this->Cliente_model();
        $this->set_atributos($objeto_banco, $objeto_cliente_model);
        return $objeto_cliente_model;
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


