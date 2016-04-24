<?php

class Servico_dao extends CI_Model {

    private $result_query; //array com resultado da query

    function __construct() {
        parent::__construct();
        $this->load->model('servico/Servico_model');
        $this->load->model('servico/Servico_composite');
        $this->load->model('cliente/Cliente_model');
        $this->load->model('cliente/Cliente_dao');
        $this->load->model('item_servico/Item_servico_dao');
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
            $this->set_servico($servico_banco[0], $servico);
            return $servico;
        }
        return;
    }

    public function get_servico_vazio() {
        return new $this->Servico_model();
    }

    private function set_servico($servico_banco, $objeto) {

        $attr = $this->Servico_model->get_atributos();
        foreach ($attr as $key => $valor):

            $metodo = "set_$key";
            $objeto->$metodo(isset($servico_banco->$key) ? $servico_banco->$key : null);
        endforeach;
    }

    public function get_servicos_composite() {

        $this->iniciar_query();
        $this->executar_query();
        $lista = $this->montar_servicos_composite();
        return $lista;
        /*
          $lista = array();

          $this->db->order_by("id_servico", "desc");
          $servicos_banco = $this->db->get('servico')->result();
          if (count($servicos_banco) > 0) {
          foreach ($servicos_banco as $servico) {
          $lista[] = $this->get_servico_composite($servico->id_servico);
          }
          }
          return $lista;
         */
    }

    public function get_servico_composite($id_servico) {
        if ($id_servico):
            $this->iniciar_query();
            $this->db->where("id_servico", $id_servico);
            $this->executar_query();
            return $this->montar_servico_composite($this->result_query[0]);
        endif;
        $servico = new $this->Servico_composite();
        $servico->set_servico($this->Servico_dao->get_servico_vazio());
        $servico->set_cliente($this->Cliente_dao->get_cliente_vazio());
        $servico->set_itens_servico($this->Item_servico_dao->get_itens_servico_vazio());
        return $servico;
        /*
          $servico_banco= array()
          if ($id_servico):
          $this->db->where('id_servico', $id_servico);
          $servico_banco = $this->db->get('servico')->result();
          endif;
          $servico = new $this->Servico_composite();
          if (count($servico_banco) > 0) {

          $servico->set_servico($this->get_servico($servico_banco[0]->id_servico));
          $servico->set_cliente($this->Cliente_dao->get_cliente($servico_banco[0]->id_cliente));
          $servico->set_itens_servico($this->Item_servico_dao->get_itens_servico($servico_banco[0]->id_servico));
          } else {
          $servico->set_servico($this->Servico_dao->get_servico_vazio());
          $servico->set_cliente($this->Cliente_dao->get_cliente_vazio());
          $servico->set_itens_servico($this->Item_servico_dao->get_itens_servico_vazio());
          }
          return $servico;
         * 
         */
    }

    private function iniciar_query() {
        $this->db->select("*");
        $this->db->from("servico s");
        $this->db->join("cliente c", "s.id_cliente=c.id_cliente", "left");
    }

    private function executar_query() {
        $this->result_query = $this->db->get()->result();
    }

    private function montar_servicos_composite() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_servico_composite($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_servico_composite($objeto_banco) {
        $objeto_composite = new $this->Servico_composite();
        $objeto_servico_model = new $this->Servico_model();
        $objeto_cliente_model = new $this->Cliente_model();
        $this->set_servico($objeto_banco, $objeto_servico_model);
        $objeto_cliente_model->set_id_cliente($objeto_banco->id_cliente);
        $objeto_cliente_model->set_nome($objeto_banco->nome);
        $objeto_cliente_model->set_telefone($objeto_banco->telefone);
        $objeto_cliente_model->set_telefone2($objeto_banco->telefone2);
        $objeto_cliente_model->set_responsavel($objeto_banco->responsavel);
        $objeto_cliente_model->set_email($objeto_banco->email);
        $objeto_cliente_model->set_cnpj($objeto_banco->cnpj);
        $objeto_composite->set_cliente($objeto_cliente_model);
        $objeto_composite->set_servico($objeto_servico_model);
        return $objeto_composite;
    }

}
