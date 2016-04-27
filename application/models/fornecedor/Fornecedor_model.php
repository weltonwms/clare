<?php

class Fornecedor_model extends Generic_model {

    protected $id_fornecedor;
    protected $empresa;
    protected $responsavel;
    protected $fone;
    protected $conta;
    protected $tabela = 'fornecedor';

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
