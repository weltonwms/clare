<?php

class Produto_model extends CI_Model {

    private $id_produto;
    private $nome;
    private $valor;
    private $id_fornecedor;

    function __construct() {
        parent::__construct();
    }

    public function cadastrar() {
        $dados = array(
            'nome' => $this->nome,
            'valor'=>  $this->valor,
            'id_fornecedor' => $this->id_fornecedor
        );
        $this->db->insert('produto', $dados);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return;
    }

    public function gravar_alteracao() {
        $dados = array(
            'nome' => $this->nome,
            'valor'=>  $this->valor,
            'id_fornecedor' => $this->id_fornecedor
        );
        $this->db->where('id_produto', $this->id_produto);
        $this->db->update('produto', $dados);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }
    
    public function atualizar_valor($valor,$id_produto){
        $this->set_valor($valor, 1);
        $this->set_id_produto($id_produto);
         $dados = array(
              'valor'=>  $this->valor,
           
        );
        $this->db->where('id_produto', $this->id_produto);
        $this->db->update('produto', $dados);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    public function excluir($id_produto) {
        $this->db->where('id_produto', $id_produto);
        $this->db->delete('produto');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    public function get_id_produto() {
        return $this->id_produto;
    }

    public function set_id_produto($id) {
        $this->id_produto = $id;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_valor() {
        return $this->valor;
    }

    public function set_valor($valor,$trata_valor=null) {
         if ($trata_valor) {
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);
        }
       
        $this->valor = $valor;
    }

    
    public function get_id_fornecedor() {
        return $this->id_fornecedor;
    }

    public function set_id_fornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;
    }

    public function is_relacionado_a_servico($id_produto) {
        $this->db->select('*');
        $this->db->from('item_servico');
        $this->db->join('servico', 'item_servico.id_servico = servico.id_servico');
        $this->db->where('item_servico.id_produto', $id_produto);
        $result = $this->db->get()->result();
        if (count($result) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

