<?php

abstract class Generic_dao extends CI_Model {
    protected $result_query; //array com resultado da query

   

    public function get_objetos_composite() {

        $this->iniciar_query();
        $this->executar_query();
        $lista = $this->montar_objetos_composite();
        return $lista;
    }

    public function get_objeto_composite($id,$nome_id) {
        if ($id):
            $this->iniciar_query();
            $this->db->where($nome_id, $id);
            $this->executar_query();
            return $this->montar_objeto_composite($this->result_query[0]);
        endif;
       
        $componentes=  $this->get_componentes_composite();
        $objeto_composite = $componentes[0];
         unset($componentes[0]);
        foreach ($componentes as $componente):
            $classe = get_class($componente);
            $classe_limpa = strtolower(str_replace("_model", "", $classe));
            $metodo = "set_" . $classe_limpa;
            $objeto_composite->$metodo($componente);
        endforeach;
        return $objeto_composite;
    }

    abstract protected function iniciar_query() ;

    protected function executar_query() {
        $this->result_query = $this->db->get()->result();
    }

    protected function montar_objetos_composite() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_objeto_composite($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_objeto_composite($objeto_banco) {
        $componentes = $this->get_componentes_composite();
        $objeto_composite = $componentes[0];
        unset($componentes[0]);
        foreach ($componentes as $componente):
            $this->set_atributos($objeto_banco, $componente);
        endforeach;

        foreach ($componentes as $componente):
            $classe = get_class($componente);
            $classe_limpa = strtolower(str_replace("_model", "", $classe));
            $metodo = "set_" . $classe_limpa;
            $objeto_composite->$metodo($componente);
        endforeach;

        return $objeto_composite;
    }

    protected function set_atributos($objeto_banco, $objeto) {

        $attr = $objeto->get_atributos();
        foreach ($attr as $key => $valor):

            $metodo = "set_$key";
            if (method_exists($objeto, $metodo)):
                $objeto->$metodo(isset($objeto_banco->$key) ? $objeto_banco->$key : null);
            endif;
        endforeach;
    }

    abstract protected function get_componentes_composite() ;
    

}
