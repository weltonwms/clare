<?php

/*
 * Esta Classe é a classe entrada do Model. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  o Cliente.
 */
include_once( APPPATH . 'models/generic/Generic_manager.php');

class Cliente_manager extends Generic_manager {

    function __construct()
    {
        parent::__construct();

        $this->load->model('cliente/Cliente_dao', 'Cliente_dao');
        $this->load->model('cliente/Cliente_model', 'Cliente_model');
    }

    public function get_clientes()
    {
        return $this->Cliente_dao->get_clientes();
    }

    public function get_cliente($id_cliente)
    {
        return $this->Cliente_dao->get_cliente($id_cliente);
    }

    public function excluir($id_cliente)
    {

        if ($this->Cliente_model->is_relacionado_a_servico($id_cliente)):
            return -1;
        endif;
        return parent::excluir($id_cliente);
    }

    protected function get_model()
    {

        return $this->Cliente_model;
    }

    protected function get_nome_id()
    {
        return "id_cliente";
    }

}
