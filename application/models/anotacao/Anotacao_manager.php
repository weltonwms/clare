<?php

/*
 * Esta Classe é a classe entrada do Model. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  o Objeto.
 */
include_once( APPPATH . 'models/generic/Generic_manager.php');
class Anotacao_manager extends Generic_manager {

    function __construct() {
        parent::__construct();
        $this->load->model("anotacao/Anotacao_dao");
       
    }
    
    public function get_anotacoes(){
        return $this->Anotacao_dao->get_anotacoes_composite();
    }
    
    public function get_anotacao($id){
         return $this->Anotacao_dao->get_anotacao($id);
    }

    protected function get_model() {
        $this->load->model('anotacao/Anotacao_model');
        return $this->Anotacao_model;
    }

    protected function get_nome_id() {
        return "id_anotacao";
    }

}


