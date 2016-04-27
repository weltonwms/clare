<?php

class Item_servico_model extends Generic_model {

    protected $id;
    protected $id_servico;
    protected $id_produto;
    protected $qtd_produto;
    protected $descricao;
    protected $valor_final;
    protected $valor_fornecedor;
    private $obj_produto; //objeto Produto_composite
    protected $tabela="item_servico";
    
    function __construct() {
        parent::__construct();
        $this->load->model('produto/Produto_dao');
    }

    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_id_servico() {
        return $this->id_servico;
    }

    public function set_id_servico($id_servico) {
        $this->id_servico = $id_servico;
    }

    public function get_id_produto() {
        return $this->id_produto;
    }

    public function set_id_produto($id_produto) {
        $this->id_produto = $id_produto;
    }

    public function get_qtd_produto() {
        return $this->qtd_produto;
    }

    public function set_qtd_produto($qtd_produto) {
        if(!$qtd_produto){
            $qtd_produto=NULL;
        }
        $this->qtd_produto = $qtd_produto;
    }

    public function get_valor_final() {
        return $this->valor_final;
    }
    
    
    public function set_valor_fornecedor($valor_fornecedor,$trata_valor=null) {
         if ($trata_valor) {
            $valor_fornecedor = str_replace(".", "", $valor_fornecedor);
            $valor_fornecedor = str_replace(",", ".", $valor_fornecedor);
        }
       
        $this->valor_fornecedor = $valor_fornecedor;
    }
    
    

        public function get_valor_final_multiplicado(){
        $qtd= $this->qtd_produto;
        if(!$qtd){
            $qtd=1;
        }
        return $this->valor_final*$qtd;
    }

    public function set_valor_final($valor,$trata_valor=null) {
        if ($trata_valor) {
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);
        }
        $this->valor_final = $valor;
    }
    
    public function get_descricao() {
        return $this->descricao;
    }

    public function set_descricao($descricao) {
        if(!$descricao){
            $descricao=NULL;
        }
        $this->descricao = $descricao;
    }

    
    protected function set_obj_produto($id_produto) {
        $this->obj_produto = $this->Produto_dao->get_produto_composite($id_produto);
    }

    public function get_nome_produto() {
        if (!is_object($this->obj_produto)) {
            $this->set_obj_produto($this->id_produto);
        }
        return $this->obj_produto->get_nome_produto();
    }

    public function get_nome_fornecedor() {
        if (!is_object($this->obj_produto)) {
            $this->set_obj_produto($this->id_produto);
        }
        return $this->obj_produto->get_nome_fornecedor();
    }
    
     public function get_valor_fornecedor() {
         return $this->valor_fornecedor;
         /*
        if (!is_object($this->obj_produto)) {
            $this->set_obj_produto($this->id_produto);
        }
        return $this->obj_produto->get_valor();
          * 
          */
    }

    public function get_nome_produto_fornecedor() {
        if (!is_object($this->obj_produto)) {
            $this->set_obj_produto($this->id_produto);
        }
        $string = $this->obj_produto->get_nome_produto() .
                "<span class='nome_fornecedor'>  - {$this->obj_produto->get_nome_fornecedor()}</span>";
        return $string;
    }
    
    public function get_valor_nome_fornecedor() {
        if (!is_object($this->obj_produto)) {
            $this->set_obj_produto($this->id_produto);
        }
        $string = "R$ " . number_format($this->obj_produto->get_valor(), 2, ",", ".").
                      "<span class='nome_fornecedor'>  - {$this->obj_produto->get_nome_fornecedor()}</span>"; 
        return $string;
    }
    
}

