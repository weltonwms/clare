<?php

abstract class Generic_dao extends CI_Model {

    protected $result_query; //array com resultado da query

    public function get_objetos()
    {

        $this->iniciar_query();
        $this->executar_query();
        $lista = $this->montar_objetos();
        return $lista;
    }

   

    public function get_objeto($id, $nome_id)
    {
        if ($id):
            $this->iniciar_query();
            $this->db->where($nome_id, $id);
            $this->executar_query();
            return $this->montar_objeto($this->result_query[0]);
        endif;

        $componentes = $this->get_componentes_composite();
        $objeto_composite = $componentes[0];
        //Caso haja mais de um componente tem que alimentar a composição com objetos vazios
        if (count($componentes) > 1):
            unset($componentes[0]);
            foreach ($componentes as $componente):
                $classe = get_class($componente);
                $classe_limpa = strtolower(str_replace("_model", "", $classe));
                $metodo = "set_" . $classe_limpa;
                $objeto_composite->$metodo($componente);
            endforeach;
        endif;
        return $objeto_composite;
    }
    

    abstract protected function iniciar_query();

    protected function executar_query()
    {
        $this->result_query = $this->db->get()->result();
    }

    

    protected function montar_objetos()
    {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_objeto($objeto_banco);
        endforeach;
        return $array;
    }

    

    private function montar_objeto($objeto_banco)
    {
        $componentes = $this->get_componentes_composite();
        $objeto_composite = $componentes[0];
        //Caso haja mais de um componente tem que alimentar a composição
        if (count($componentes) > 1):
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
        else:
            $this->set_atributos($objeto_banco, $objeto_composite);
        endif;
        return $objeto_composite;
    }

    protected function set_atributos($objeto_banco, $objeto)
    {

        $attr = $objeto->get_atributos();
        foreach ($attr as $key => $valor):

            $metodo = "set_$key";
            if (method_exists($objeto, $metodo)):
                $objeto->$metodo(isset($objeto_banco->$key) ? $objeto_banco->$key : null);
            endif;
        endforeach;
    }
    /**
     * Método que retorna os componentes da composição.
     * Caso não não haja composição deverá ser retornado um array com apenas 1 elemento.
     * Caso haja composição o 1º elemento do array deverá ser a classe composite.
     * @return array Retorna array com os objetos que formam a composição
     */
    abstract protected function get_componentes_composite();
}
