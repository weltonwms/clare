<?php


class Servico_composite extends CI_Model{
    private $servico; //objeto Servico_model
    private $itens_servico; //array de objetos tipo Item_servico_model
    private $cliente; //objeto Cliente_model
    
    public function __construct() {
        parent::__construct();
        $this->load->model('item_servico/Item_servico_dao');
    }
    
    public function set_servico(Servico_model $servico){
        $this->servico=$servico;
    }
    
    public function set_cliente(Cliente_model $cliente){
        $this->cliente=$cliente;
    }
    
    public function set_itens_servico(array $itens_servico){
        $this->itens_servico=$itens_servico;
    }
    
    public function get_id_servico(){
        return $this->servico->get_id_servico();
    }
    
    public function get_id_cliente(){
        return $this->servico->get_id_cliente();
    }
    
    public function get_nome_cliente(){
        return $this->cliente->get_nome();
    }
    
    public function get_endereco_cliente(){
        return $this->cliente->get_endereco();
    }
    
    public function get_responsavel_cliente(){
        return $this->cliente->get_responsavel();
    }
    
    public function get_telefone_cliente(){
        return $this->cliente->get_telefone();
    }
    
   
    
   
    
    public function get_data(){
        return $this->servico->get_data();
    }
    
    public function get_estado(){
        return $this->servico->get_estado();
    }
    
     public function get_obs(){
        return $this->servico->get_obs();
    }
    
    public function get_forma_pagamento(){
        return $this->servico->get_forma_pagamento();
    }
    
    public function get_nome_estado(){
        return $this->servico->get_nome_estado();
    }
    
    public function get_tipo(){
        return $this->servico->get_tipo();
    }
    
    public function get_nome_tipo(){
        return $this->servico->get_nome_tipo();
    }

    public function get_itens_servico() {
        if(!$this->itens_servico):
            $itens=$this->Item_servico_dao->get_itens_servico($this->get_id_servico());
            $this->itens_servico=$itens;
        endif;
        return $this->itens_servico;
    }
    
     public function get_email_cliente(){
        return $this->cliente->get_email();
    }
    
    public function get_total_itens_servico(){
        $soma=0;
        foreach($this->itens_servico as $item):
            $soma+=$item->get_valor_final_multiplicado();
        endforeach;
        return $soma;
    }
    
   


    
    
   
}


