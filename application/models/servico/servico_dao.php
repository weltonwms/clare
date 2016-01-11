<?php

class Servico_dao extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('servico/Servico_model');
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
    
    public function get_servico_vazio(){
        return new $this->Servico_model();;
    }
    
    private function set_servico($servico_banco, $objeto) {
        
        $attr = $this->Servico_model->get_atributos();
        foreach ($attr as $key => $valor):
            
            $metodo = "set_$key";
            $objeto->$metodo(isset($servico_banco->$key) ? $servico_banco->$key : null);
        endforeach;
        
        
    }

}

