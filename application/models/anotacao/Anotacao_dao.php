<?php

class Anotacao_dao extends CI_Model {

    private $result_query; //array com resultado da query

    function __construct() {
        parent::__construct();
        $this->load->model('anotacao/Anotacao_model');
        $this->load->model('anotacao/Anotacao_composite');
        $this->load->model('fornecedor/Fornecedor_dao');
        
    }

     public function get_anotacoes() {

        $lista = array();
        $this->db->order_by("id_anotacao", "desc");
        $anotacoes_banco = $this->db->get('anotacao')->result();
        if (count($anotacoes_banco) > 0) {
            foreach ($anotacoes_banco as $anotacao) {
                $lista[] = $this->get_anotacao($anotacao->id_anotacao);
            }
        }
        return $lista;
    }

    public function get_anotacao($id_anotacao) {
        $this->db->where('id_anotacao', $id_anotacao);
        $anotacao_banco = $this->db->get('anotacao')->result();
        if (count($anotacao_banco) > 0) {
            $anotacao = new $this->Anotacao_model();
            $this->set_atributos($anotacao_banco[0], $anotacao);
            return $anotacao;
        }
        return $this->get_anotacao_vazia();
    }

    public function get_anotacao_vazia() {
        return new $this->Anotacao_model();
    }

    public function get_anotacoes_composite() {

        $this->iniciar_query();
        $this->executar_query();
        $lista = $this->montar_objetos_composite();
        return $lista;
       
    }

    public function get_anotacao_composite($id) {
        if ($id):
            $this->iniciar_query();
            $this->db->where("id_anotacao", $id);
            $this->executar_query();
            return $this->montar_objeto_composite($this->result_query[0]);
        endif;
        $anotacao = new $this->Anotacao_composite();
        $anotacao->set_anotacao($this->get_anotacao_vazia());
        $anotacao->set_fornecedor($this->Fornecedor_dao->get_fornecedor_vazio());
       
        return $anotacao;
      
    }

    private function iniciar_query() {
        $this->db->select("*");
        $this->db->from("anotacao a");
        $this->db->join("fornecedor f", "a.id_fornecedor=f.id_fornecedor", "left");
    }

    private function executar_query() {
        $this->result_query = $this->db->get()->result();
    }

    private function montar_objetos_composite() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_objeto_composite($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_objeto_composite($objeto_banco) {
        $objeto_composite = new $this->Anotacao_composite();
        $objeto_anotacao_model = new $this->Anotacao_model();
        $objeto_fornecedor_model = new $this->Fornecedor_model();
        
        $this->set_atributos($objeto_banco, $objeto_anotacao_model);
        $this->set_atributos($objeto_banco, $objeto_fornecedor_model);
        
        $objeto_composite->set_anotacao($objeto_anotacao_model);
        $objeto_composite->set_fornecedor($objeto_fornecedor_model);
        return $objeto_composite;
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


