<?php

/*
 * Esta Classe é a classe entrada do Model Servico. Responsável por intermediar com o
 * Controler. Ela utiliza as outras Classes Model que ajudam a realizar todo o 
 * trabalho com  a Servico.
 */

class Servico_manager extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('servico/Servico_composite_dao');
    }

    public function get_servicos() {
        return $this->Servico_composite_dao->get_servicos_composite();
    }

    public function get_servico($id_servico) {
        return $this->Servico_composite_dao->get_servico_composite($id_servico);
    }

    public function salvar_servico($post) {
        $retorno = array();
        if ($post['id_servico']) {
            $retorno['status'] = (int) $this->gravar_alteracao($post);
            $retorno['acao_executada'] = 'alteracao';
        } else {
            $retorno['status'] = $this->cadastrar($post);
            $retorno['acao_executada'] = 'cadastro';
        }

        return $retorno;
    }
    
    public function executar_servico($id_servico){
         $this->load->model('servico/Servico_model', 'servico');
         return $this->servico->executar_servico($id_servico);
    }

    public function cadastrar(array $post) {
        $this->load->model('servico/Servico_model', 'servico');
        $this->set_servico($post);
        return $this->servico->cadastrar();
    }

    public function gravar_alteracao(array $post) {
        $this->load->model('servico/Servico_model', 'servico');
        $this->set_servico($post);
        return $this->servico->gravar_alteracao();
    }

    public function excluir($id_servico) {
        $this->load->model('servico/Servico_model', 'servico');
        return $this->servico->excluir($id_servico);
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
            $this->gravar_alteracao($post);
            $id_servico = $post['id_servico'];
        } else {
            $id_servico = $this->cadastrar($post);
        }
        $this->Produto_model->atualizar_valor($post['valor_fornecedor'],$post['id_produto']);
        if ($post['id_item_servico']) {
            $retorno = $this->item_servico_m->gravar_alteracao($post);
            $acao='alteracao';
            //atualizar item de servico
        } else {
            $post['id_servico'] = $id_servico;
            $retorno = $this->item_servico_m->cadastrar($post);
            $acao='cadastro';
            //cadastrar item_servico
        }
        return array('id_servico' => $id_servico, 'status' => $retorno,'acao_executada'=>$acao);
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

    private function set_servico($post, $skips = array()) {
        $this->load->model('servico/Servico_model', 'servico');
        $attr = $this->servico->get_atributos();
        foreach ($attr as $key => $valor):
            if (in_array($key, $skips)) {
                continue;
            }
            $metodo = "set_$key";
            $this->servico->$metodo(isset($post[$key]) ? $post[$key] : null);
        endforeach;
        
    }

}

