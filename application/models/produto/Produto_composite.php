<?php


class Produto_composite extends CI_Model{
    private $produto;
    private $fornecedor;
   
    
    public function set_produto(Produto_model $produto){
        $this->produto=$produto;
    }
    
    public function set_fornecedor(Fornecedor_model $fornecedor){
        $this->fornecedor=$fornecedor;
    }
    
   public function get_id_produto(){
        return $this->produto->get_id_produto();
    }
    
    public function get_id_fornecedor(){
        return $this->fornecedor->get_id_fornecedor();
    }
    
    public function get_nome_produto(){
        return $this->produto->get_nome();
    }
    
     public function get_nome_fornecedor(){
        return $this->fornecedor->get_empresa();
    }
    
    public function get_valor(){
        return $this->produto->get_valor();
    }
    
     public function get_nome_produto_fornecedor(){
        $string=$this->produto->get_nome().
                " - <span class='nome_fornecedor'>{$this->fornecedor->get_empresa()}</span>";
        return $string;
    }
    
    
    
    
   
}


