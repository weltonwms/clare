<?php

class Produto_dao extends CI_Model {

    private $result_query; //array com resultado da query

    function __construct() {
        parent::__construct();
        $this->load->model('produto/Produto_model');
        $this->load->model('produto/Produto_composite');
        $this->load->model('fornecedor/Fornecedor_dao');
        $this->load->model('fornecedor/Fornecedor_model');
    }

    public function get_produtos() {
        $lista = array();
        $this->db->order_by("nome", "asc");
        $produtos_banco = $this->db->get('produto')->result();
        if (count($produtos_banco) > 0) {
            foreach ($produtos_banco as $produto) {
                $lista[] = $this->get_produto($produto->id_produto);
            }
        }
        return $lista;
    }

    public function get_produto($id_produto) {
        $this->db->where('id_produto', $id_produto);
        $produto_banco = $this->db->get('produto')->result();
        if (count($produto_banco) > 0) {
            $produto = new $this->Produto_model();
            $produto->set_id_produto($produto_banco[0]->id_produto);
            $produto->set_nome($produto_banco[0]->nome);
            $produto->set_valor($produto_banco[0]->valor);
            $produto->set_id_fornecedor($produto_banco[0]->id_fornecedor);

            return $produto;
        }
        return;
    }

    public function get_produtos_composite() {
        $this->iniciar_query();
        $this->db->order_by("nome", "asc");
        $this->executar_query();
        $lista = $this->montar_produtos_composite();
        return $lista;
    }

    public function get_produto_composite($id_produto) {
        $this->iniciar_query();
        $this->db->where("id_produto", $id_produto);
        $this->executar_query();
        return $this->montar_produto_composite($this->result_query[0]);
    }

    private function iniciar_query() {
        $this->db->select("*");
        $this->db->from("produto p");
        $this->db->join("fornecedor f", "p.id_fornecedor=f.id_fornecedor", "left");
    }

    private function executar_query() {
        $this->result_query = $this->db->get()->result();
    }

    private function montar_produtos_composite() {
        $array = array();
        foreach ($this->result_query as $objeto_banco):
            $array[] = $this->montar_produto_composite($objeto_banco);
        endforeach;
        return $array;
    }

    private function montar_produto_composite($objeto_banco) {
        $objeto_composite = new $this->Produto_composite();
        $objeto_produto_model = new $this->Produto_model();
        $objeto_fornecedor_model = new $this->Fornecedor_model();
        
        $objeto_produto_model->set_id_produto($objeto_banco->id_produto);
        $objeto_produto_model->set_id_fornecedor($objeto_banco->id_fornecedor);
        $objeto_produto_model->set_nome($objeto_banco->nome);
        $objeto_produto_model->set_valor($objeto_banco->valor);
        
        $objeto_fornecedor_model->set_empresa($objeto_banco->empresa);
        $objeto_fornecedor_model->set_responsavel($objeto_banco->responsavel);
        $objeto_fornecedor_model->set_conta($objeto_banco->conta);
        
        $objeto_composite->set_produto($objeto_produto_model);
        $objeto_composite->set_fornecedor($objeto_fornecedor_model);
        return $objeto_composite;
    }

}
