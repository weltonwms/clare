<?php

/*
 * Esta Classe é a classe entrada do Model Servico. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  a Servico.
 */

class Item_servico_manager extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('item_servico/Item_servico_model');
    }

    public function cadastrar(array $post) {
        //echo "<pre>"; print_r($post); exit();
        if ($post['id_produto']):
            $this->Item_servico_model->set_id_servico($post['id_servico']);
            $this->Item_servico_model->set_id_produto($post['id_produto']);
            $this->Item_servico_model->set_qtd_produto($post['qtd_produto']);
            $this->Item_servico_model->set_valor_final($post['valor_final'], 1);
            $this->Item_servico_model->set_valor_fornecedor($post['valor_fornecedor'],1);
            $this->Item_servico_model->set_descricao($post['descricao']);

            return $this->Item_servico_model->cadastrar();
        endif;
        return FALSE;
    }

    public function gravar_alteracao(array $post) {
        if ($post['id_produto']):
            $this->Item_servico_model->set_id($post['id_item_servico']);

            $this->Item_servico_model->set_id_servico($post['id_servico']);
            $this->Item_servico_model->set_id_produto($post['id_produto']);
            $this->Item_servico_model->set_qtd_produto($post['qtd_produto']);
            $this->Item_servico_model->set_valor_final($post['valor_final'], 1);
            $this->Item_servico_model->set_valor_fornecedor($post['valor_fornecedor'],1);
            $this->Item_servico_model->set_descricao($post['descricao']);

            return $this->Item_servico_model->gravar_alteracao();
        endif;
        return FALSE;
    }

    public function excluir($id_item_servico) {

        return $this->Item_servico_model->excluir($id_item_servico);
    }
    
    public function clonar($id_origem,$id_destino){
        $this->db->where('id_servico',$id_origem);
        $data=$this->db->get('item_servico')->result_array();
        foreach($data as $key=>$valor):
            $data[$key]['id_servico']=$id_destino;
            unset($data[$key]['id']);
        endforeach;
        
        return $this->db->insert_batch('item_servico', $data); 
    }

}

