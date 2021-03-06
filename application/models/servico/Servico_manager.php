<?php

/*
 * Esta Classe é a classe entrada do Model Servico. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  a Servico.
 */
include_once( APPPATH . 'models/generic/Generic_manager.php');
class Servico_manager extends Generic_manager {

    function __construct() {
        parent::__construct();
        $this->load->model('servico/Servico_dao');
    }

    public function get_servicos() {
        return $this->Servico_dao->get_servicos_composite();
    }

    public function get_servico($id_servico) {
        return $this->Servico_dao->get_servico_composite($id_servico);
    }

    public function executar_servico($id_servico) {
         $servico=  $this->get_servico($id_servico);
         if($servico->get_estado()!=2):
            return $servico->executar_servico();
        endif;
    }

    public function excluir_item_servico($id_item_servico) {
        $this->load->model('item_servico/Item_servico_manager', 'item_servico_m');
        return $this->item_servico_m->excluir($id_item_servico);
    }

    public function manter_itens_servico(array $post) {
        $this->load->model('item_servico/Item_servico_manager', 'item_servico_m');
        $this->load->model('produto/Produto_model');
        $id_servico = NULL;
        if ($post['id_servico']) {
            $this->alterar($post);
            $id_servico = $post['id_servico'];
        } else {
            $id_servico = $this->cadastrar($post);
        }
        //echo "<pre>"; print_r($post); exit();
        $this->Produto_model->atualizar_valor($post);
        if ($post['id_item']) {
            //atualizar item de servico
            $retorno = $this->item_servico_m->alterar($post);
            $acao = 'alteracao';
        } else {
            //cadastrar item_servico
            $post['id_servico'] = $id_servico;
            $retorno = $this->item_servico_m->cadastrar($post);
            $acao = 'cadastro';
            
        }
        return array('id_servico' => $id_servico, 'status' => $retorno, 'acao_executada' => $acao);
    }

    public function clonar($post) {
        $retorno = FALSE;
        $id_servico = $this->cadastrar($post);
        if ($id_servico):
            $this->load->model('item_servico/Item_servico_manager', 'item_manager');
            $retorno = $this->item_manager->clonar($post['id_servico'], $id_servico);
        endif;

        return $retorno;
    }
    
    public function get_vendedores(){
        return $this->db->get('vendedor')->result();
    }

    protected function get_model() {
         $this->load->model('servico/Servico_model');
         return $this->Servico_model;
    }

    protected function get_nome_id() {
         return "id_servico";
    }

    public function updateContaBoleto($post) {
        $id_servico = $post['id_servico'];

        if($id_servico){
            $conta_boleto= $post['conta_boleto']?$post['conta_boleto']:null;
            $dados = [
                "conta_boleto" =>$conta_boleto
            ];

            $this->db->where('id_servico', $id_servico);
            return $this->db->update('servico', $dados);
        }
       
    }

}
