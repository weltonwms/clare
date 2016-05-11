<?php

/*
 * Esta Classe é a classe entrada do Model. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  o Cliente.
 */

class Cliente_manager extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->model('generic/Generic_model');
        $this->load->model('cliente/Cliente_dao', 'Cliente_dao');
        $this->load->model('cliente/Cliente_model', 'Cliente_model');
    }

    public function get_clientes() {
        return $this->Cliente_dao->get_clientes();
    }

    public function get_cliente($id_cliente) {
        return $this->Cliente_dao->get_cliente($id_cliente);
    }

    public function cadastrar(array $post) {
        $this->Cliente_model->set_nome($post['nome']);
        $this->Cliente_model->set_endereco($post['endereco']);
        $this->Cliente_model->set_telefone($post['telefone']);
        $this->Cliente_model->set_telefone2($post['telefone2']);
        $this->Cliente_model->set_telefone3($post['telefone3']);
        $this->Cliente_model->set_responsavel($post['responsavel']);
        $this->Cliente_model->set_cnpj($post['cnpj']);
        $this->Cliente_model->set_email($post['email']);

        return $this->Cliente_model->cadastrar();
    }

    public function excluir($id_cliente) {
        if ($this->Cliente_model->is_relacionado_a_servico($id_cliente)):
            return -1;
        endif;
        $this->Cliente_model->excluir($id_cliente);
        return 1;
    }

    public function gravar_alteracao(array $post) {
        $this->Cliente_model->set_id_cliente($post['id_cliente']);
        $this->Cliente_model->set_nome($post['nome']);
        $this->Cliente_model->set_endereco($post['endereco']);
        $this->Cliente_model->set_telefone($post['telefone']);
        $this->Cliente_model->set_telefone2($post['telefone2']);
        $this->Cliente_model->set_telefone3($post['telefone3']);
        $this->Cliente_model->set_responsavel($post['responsavel']);
        $this->Cliente_model->set_cnpj($post['cnpj']);
        $this->Cliente_model->set_email($post['email']);

        return $this->Cliente_model->alterar();
    }

}


