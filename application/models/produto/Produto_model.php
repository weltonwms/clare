<?php
include_once( APPPATH . 'models/generic/Generic_model.php');

class Produto_model extends Generic_model {

    protected $id_produto;
    protected $nome;
    protected $valor;
    protected $id_fornecedor;
    protected $tabela = 'produto';

    function __construct() {
        parent::__construct();
    }

    public function atualizar_valor($valor, $id_produto) {
        $this->set_valor($valor, 1);
        $this->set_id_produto($id_produto);
        $dados = array(
            'valor' => $this->valor,
        );
        $this->db->where('id_produto', $this->id_produto);
        $this->db->update('produto', $dados);
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

    public function set_valor($valor, $trata_valor = null) {
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
        }
        return FALSE;
    }

    

}
