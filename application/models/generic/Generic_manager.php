<?php

abstract class Generic_manager extends CI_Model {

    public function salvar($post) {
        $retorno = array();
        $nome_id = $this->get_nome_id();
        if ($post[$nome_id]) {
            $retorno['status'] = (int) $this->alterar($post);
            $retorno['acao_executada'] = 'alteracao';
        } else {
            $retorno['status'] = $this->cadastrar($post);
            $retorno['acao_executada'] = 'cadastro';
        }

        return $retorno;
    }

    public function cadastrar(array $post) {
        $model = $this->get_model();
        $this->set_objeto($post);
        return $model->cadastrar();
    }

    public function alterar(array $post) {
        $model = $this->get_model();
        $this->set_objeto($post);
        return $model->alterar();
    }

    public function excluir($id) {
        $model = $this->get_model();
        return $model->excluir($id);
    }

    protected function set_objeto($post, $skips = array()) {

        $model = $this->get_model();

        $attr = $model->get_atributos();
        foreach ($attr as $key => $valor):
            if (in_array($key, $skips)) {
                continue;
            }
            $metodo = "set_$key";
            if (method_exists($model, $metodo)):
                $model->$metodo(isset($post[$key]) ? $post[$key] : null);
            endif;
        endforeach;
        //echo "<pre>"; print_r($model); exit();
    }

    abstract protected function get_model();

    abstract protected function get_nome_id();
}
