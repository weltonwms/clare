<?php

class Fornecedor_model extends CI_Model {

    private $id_fornecedor;
    private $empresa;
    private $responsavel;
    private $fone;
    private $conta;

    function __construct() {
        parent::__construct();
    }
    
    public function get_responsavel() {
        return $this->responsavel;
    }

    public function set_responsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    public function get_fone() {
        return $this->fone;
    }

    public function set_fone($fone) {
        $this->fone = $fone;
    }

    public function get_id_fornecedor() {
        return $this->id_fornecedor;
    }

    public function set_id_fornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;
    }

    public function get_empresa() {
        return $this->empresa;
    }

    public function set_empresa($empresa) {
        $this->empresa = $empresa;
    }
    
    public function get_conta() {
        return $this->conta;
    }

    public function set_conta($conta) {
        $this->conta = $conta;
    }

    
    public function cadastrar() {
        $dados = array(
            'empresa' => $this->empresa,
            'responsavel'=>$this->responsavel,
            'fone'=>  $this->fone,
            'conta'=> $this->conta
        );
        $this->db->insert('fornecedor', $dados);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return;
    }

    public function excluir($id_fornecedor) {
        $this->db->where('id_fornecedor', $id_fornecedor);
        $this->db->delete('fornecedor');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    public function gravar_alteracao() {
        $dados = array(
            'empresa' => $this->empresa,
            'responsavel'=>$this->responsavel,
            'fone'=>  $this->fone,
            'conta'=> $this->conta
        );
        $this->db->where('id_fornecedor', $this->id_fornecedor);
        $this->db->update('fornecedor', $dados);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return;
    }

    public function is_relacionado_a_produto($id_fornecedor) {
        $this->db->where('id_fornecedor', $id_fornecedor);
        $result = $this->db->get('produto')->result();
        if (count($result) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

