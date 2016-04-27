<?php
/*
 * Esta Classe é a classe entrada do Model. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  o Fornecedor.
 */
class Fornecedor_manager extends CI_Model{
    
    function __construct() {
        parent::__construct();
        $this->load->model('generic/Generic_model');
        $this->load->model('fornecedor/Fornecedor_dao','Fornecedor_dao');
        $this->load->model('fornecedor/Fornecedor_model','Fornecedor_model');
    }
    
    public function get_fornecedores($chave_array_igual_id = null){
        return $this->Fornecedor_dao->get_fornecedores($chave_array_igual_id);
    }
    
    public function get_fornecedor($id_fornecedor){
       return $this->Fornecedor_dao->get_fornecedor($id_fornecedor);
    }
    
    public function cadastrar(array $post){
        $this->Fornecedor_model->set_empresa($post['empresa']);
        $this->Fornecedor_model->set_responsavel($post['responsavel']);
        $this->Fornecedor_model->set_fone($post['fone']);
        $this->Fornecedor_model->set_conta($post['conta']);
       return $this->Fornecedor_model->cadastrar();
    }
    
    public function excluir($id_fornecedor){
        if($this->Fornecedor_model->is_relacionado_a_produto($id_fornecedor)):
            return -1;
        endif;
        $this->Fornecedor_model->excluir($id_fornecedor);
        return 1;
    }
    
    public function gravar_alteracao(array $post){
        $this->Fornecedor_model->set_id_fornecedor($post['id_fornecedor']);
        $this->Fornecedor_model->set_responsavel($post['responsavel']);
        $this->Fornecedor_model->set_fone($post['fone']);
        $this->Fornecedor_model->set_empresa($post['empresa']);
        $this->Fornecedor_model->set_conta($post['conta']);     
        return $this->Fornecedor_model->alterar();
    }
    
}

?>
