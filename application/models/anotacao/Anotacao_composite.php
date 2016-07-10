<?php


class Anotacao_composite extends CI_Model{
    private $anotacao; //objeto Anotacao_model
    private $fornecedor; //objeto Fornecedor_model
    
    public function set_anotacao(Anotacao_model $anotacao){
        $this->anotacao=$anotacao;
        
    }
    
    public function set_fornecedor(Fornecedor_model $fornecedor) {
        $this->fornecedor = $fornecedor;
    }
    
     public function get_id_anotacao() {
        return $this->anotacao->get_id_anotacao();
    }

    public function get_descricao() {
        return $this->anotacao->get_descricao();
    }

    public function get_id_fornecedor() {
        return $this->anotacao->get_id_fornecedor();
    }

     public function get_data() {
        return $this->anotacao->get_data();
    }

    public function get_estado() {
        return $this->anotacao->get_estado();
    }
    
    public function get_nome_estado() {
        return $this->anotacao->get_nome_estado();
    }
    
     public function get_nome_fornecedor() {
        return $this->fornecedor->get_empresa();
    }


   
}