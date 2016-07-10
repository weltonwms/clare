<?php

/*
 * Esta Classe é a classe entrada do Model Servico. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  a Servico.
 */

include_once( APPPATH . 'models/generic/Generic_manager.php');
class Item_servico_manager extends Generic_manager {

    function __construct() {
        parent::__construct();
    }

    public function cadastrar(array $post) {
       if ($post['id_produto']):
            return parent::cadastrar($post);
        endif;
        return FALSE;
    }

    public function alterar(array $post) {
       if ($post['id_produto']):
            return parent::alterar($post);
        endif;
        return FALSE;
    }
    
    protected function after_set_objeto($model, $post) {
         $model->set_valor_final($post['valor_final'], 1);
         $model->set_valor_fornecedor($post['valor_fornecedor'],1);
         $model->set_total_fornecedor($post['total_fornecedor'], 1);
         $model->set_total_venda($post['total_venda'],1);
    }
    
    
    public function clonar($id_origem,$id_destino){
        $this->db->where('id_servico',$id_origem);
        $data=$this->db->get('item_servico')->result_array();
        foreach($data as $key=>$valor):
            $data[$key]['id_servico']=$id_destino;
            unset($data[$key]['id_item']);
        endforeach;
        
        return $this->db->insert_batch('item_servico', $data); 
    }

     protected function get_model() {
        $this->load->model('item_servico/Item_servico_model');
        return $this->Item_servico_model;
    }

    protected function get_nome_id() {
        return "id_item";
    }
    
   

}

