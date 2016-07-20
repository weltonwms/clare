<?php

class Item_servico_composite extends CI_Model {

    private $item_servico; //objeto item_servico_model
    private $servico;   // objeto servico_model
    private $cliente; //objeto cliente_model
    private $produto; //objeto Produto_model

    public function set_item_servico(Item_servico_model $item_servico) {
        $this->item_servico = $item_servico;
    }

    public function set_servico(Servico_model $servico) {
        $this->servico = $servico;
    }

    public function set_cliente(Cliente_model $cliente) {
        $this->cliente = $cliente;
    }

    public function set_produto(Produto_model $produto) {
        $this->produto = $produto;
    }

    public function get_id_servico() {
        return $this->servico->get_id_servico();
    }

    public function get_data_servico() {
        return $this->servico->get_data();
    }

    public function get_estado_servico() {
        return $this->servico->get_nome_estado();
    }

    public function get_tipo_servico() {
        $tipo = $this->servico->get_nome_tipo();
        if ($this->servico->get_tipo() == 2):
            $tipo.= " ({$this->servico->get_porcentagem_comissao()}%)";
        endif;
        return $tipo;
    }

    public function get_nome_produto() {
        return $this->produto->get_nome();
    }

    public function get_valor_produto() {
        return $this->produto->get_valor();
    }

    public function get_valor_unitario_venda() {
        return $this->item_servico->get_valor_unitario_venda();
    }

    public function get_total_venda($formatar=FALSE) {
         if ($formatar):
                return $this->formatar_valor($this->item_servico->get_total_venda());
         endif;
        return $this->item_servico->get_total_venda();
    }

    public function get_valor_unitario_fornecedor() {
        return $this->item_servico->get_valor_unitario_fornecedor();
    }

    public function get_total_fornecedor($formatar = false) {
        $total_fornecedor = $this->item_servico->get_total_fornecedor();
        if ($formatar):
            return $this->formatar_valor($total_fornecedor);
        endif;
        return $total_fornecedor;
    }

    public function get_lucro($formatar = FALSE) {
        $total_fornecedor = $this->item_servico->get_total_fornecedor();
        $total_venda = $this->item_servico->get_total_venda();
        if ($total_fornecedor != NULL):
            switch ($this->servico->get_tipo()):
                case 2: $lucro = $this->calcular_lucro_comissao($total_fornecedor);
                    break;
                default : $lucro = $this->calcular_lucro_default($total_fornecedor, $total_venda);
            endswitch;
            if ($formatar):
                return $this->formatar_valor($lucro);
            endif;
            return $lucro;
        endif;
    }

    private function calcular_lucro_default($total_fornecedor, $total_venda) {
        return $total_venda - $total_fornecedor;
    }

    private function calcular_lucro_comissao($total_fornecedor) {
        $pc = $this->servico->get_porcentagem_comissao();
        if ($pc):
            return $total_fornecedor * ($pc / 100);
        endif;
    }

    private function formatar_valor($valor) {
        if ($valor != NULL):
            return "R$ " . number_format($valor, 2, ",", ".");
        endif;
    }

    public function get_descricao() {

        return $this->item_servico->get_descricao();
    }

    public function get_nome_cliente() {
        return $this->cliente->get_nome();
    }

    public function get_qtd_produto() {
        return $this->item_servico->get_qtd_produto();
    }

}
