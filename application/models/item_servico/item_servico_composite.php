<?php


class Item_servico_composite extends CI_Model{
    private $item_servico; //objeto item_servico_model
    private $servico;   // objeto servico_model
    private $cliente; //objeto cliente_model
    private $produto; //objeto Produto_model
    
    public function set_item_servico(Item_servico_model $item_servico) {
        $this->item_servico = $item_servico;
    }

    public function set_servico(Servico_model $servico) {
        $this->servico = $servico;
    }

    public function set_cliente(Cliente_model $cliente) {
        $this->cliente = $cliente;
    }
    
    public function set_produto(Produto_model $produto) {
        $this->produto = $produto;
    }

        
    public function get_id_servico(){
        return $this->servico->get_id_servico();
    }
    
    public function get_data_servico(){
        return $this->servico->get_data();
    }
    
    public function get_estado_servico(){
        return $this->servico->get_nome_estado();
    }
    
     public function get_tipo_servico(){
        return $this->servico->get_nome_tipo();
    }
    
    public function get_nome_produto(){
        return $this->produto->get_nome();
    }
    
    public function get_valor_produto(){
        return $this->produto->get_valor();
    }
    public function get_valor_final(){
        return $this->item_servico->get_valor_final();
    }
    
     public function get_valor_fornecedor(){
        return $this->item_servico->get_valor_fornecedor();
    }
    
    public function get_valor_final_formatado(){
        return "R$ ".number_format($this->item_servico->get_valor_final(), 2,",", ".");
    }
    
    public function get_valor_final_multiplicado(){
        return $this->item_servico->get_valor_final_multiplicado();
    }
    
    public function get_valor_final_multiplicado_formatado(){
        return "R$ ".number_format($this->item_servico->get_valor_final_multiplicado(), 2,",", ".");
    }
    
    public function get_descricao(){
       
        return $this->item_servico->get_descricao();
    }
    
    public function get_nome_cliente(){
        return $this->cliente->get_nome();
    }
    
    public function get_qtd_produto(){
        return $this->item_servico->get_qtd_produto();
    }
    
    


}