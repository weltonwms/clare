<?php
/*
 * Esta Classe é a classe entrada do Model Produto. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  a Produto.
 */
class Produto_manager extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('generic/Generic_model');
        $this->load->model('produto/Produto_dao');
    }

    public function get_produtos() {
       return $this->Produto_dao->get_produtos_composite();
    }
    
   
    public function get_produto($id_produto) {
        return $this->Produto_dao->get_produto_composite($id_produto);
    }
    
    public function cadastrar(array $post){
        $this->load->model('produto/Produto_model','produto');
        $this->produto->set_nome($post['nome']);
        $this->produto->set_valor(isset($post['valor'])?$post['valor']:NULL,1);
        $this->produto->set_id_fornecedor($post['id_fornecedor']);
        return $this->produto->cadastrar();
    }
    
    public function gravar_alteracao(array $post){
        $this->load->model('produto/Produto_model','produto');
        $this->produto->set_id_produto($post['id_produto']);
        $this->produto->set_nome($post['nome']);
        $this->produto->set_valor(isset($post['valor'])?$post['valor']:NULL,1);
        $this->produto->set_id_fornecedor($post['id_fornecedor']);
        return $this->produto->alterar();
    }
    
    public function excluir($id_produto){
        $this->load->model('produto/Produto_model','produto');
        if($this->Produto_model->is_relacionado_a_servico($id_produto)){
            return -1;
        }
        $this->produto->excluir($id_produto);  
        return 1;
    }

}

