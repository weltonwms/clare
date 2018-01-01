<?php

/**
 * classe utilizada para Relatório
 */
class Pagamento_composite extends CI_Model {

    private $pagamento; //objeto Pagamento_model
    private $servico;   // objeto servico_model
    private $cliente; //objeto cliente_model
    private $lista_servicos_composite; //array com servicos utilizado em relatorio fluxo

    public function set_pagamento(Pagamento_model $pagamento)
    {
        $this->pagamento = $pagamento;
    }

    public function set_servico(Servico_model $servico)
    {
        $this->servico = $servico;
    }

    public function set_cliente(Cliente_model $cliente)
    {
        $this->cliente = $cliente;
    }

    public function set_lista_servicos_composite($lista_servicos_composite)
    {
        $this->lista_servicos_composite = $lista_servicos_composite;
    }

    public function get_id_servico()
    {
        return $this->servico->get_id_servico();
    }

    public function get_data_servico()
    {
        return $this->servico->get_data();
    }

    public function get_estado_servico()
    {
        return $this->servico->get_nome_estado();
    }

    public function get_tipo_servico()
    {
        $tipo = $this->servico->get_nome_tipo();
        if ($this->servico->get_tipo() == 2):
            $tipo.= " ({$this->servico->get_porcentagem_comissao()}%)";
        endif;
        return $tipo;
    }

    public function get_id_vendedor()
    {
        return $this->servico->get_id_vendedor();
    }

    public function get_nome_cliente()
    {
        return $this->cliente->get_nome();
    }

    public function get_nome_vendedor()
    {
        $nomes = array(0 => '', 1 => 'Glauber', 2 => "Maurício", 3 => "Paulo", '' => ""); //substituir por model vendedor;
        return $nomes[$this->get_id_vendedor()];
    }

    public function get_tipo_pagamento()
    {
        return $this->pagamento->get_nome_tipo_pagamento();
    }

    public function get_valor_pago()
    {
        return $this->pagamento->get_valor_pago();
    }

    public function get_valor_pago_formatado()
    {
        return $this->pagamento->get_valor_pago_formatado();
    }

    public function get_data_pagamento()
    {
        return $this->pagamento->get_data();
    }

    public function get_data_pagamento_formatada()
    {
        return $this->pagamento->get_data_formatada();
    }

    public function get_total_geral_venda()
    {
        $servico_composite = $this->lista_servicos_composite[$this->get_id_servico()];
        return $servico_composite->get_total_geral_venda();
    }

    public function get_total_geral_fornecedor()
    {
        $servico_composite = $this->lista_servicos_composite[$this->get_id_servico()];
        return $servico_composite->get_total_geral_fornecedor();
    }

    public function get_lucro_venda()
    {
        $servico_composite = $this->lista_servicos_composite[$this->get_id_servico()];
        $pc = $servico_composite->get_porcentagem_comissao();
        if ($servico_composite->get_tipo() == 2 && $pc):
            return $servico_composite->get_total_geral_fornecedor() * ($pc / 100);
        endif;
        return $this->get_total_geral_venda() - $this->get_total_geral_fornecedor();
    }

    public function get_total_geral_venda_formatado()
    {
        return number_format($this->get_total_geral_venda(), 2, ',', '.');
    }

    public function get_operacao()
    {
        return $this->pagamento->get_operacao();
    }

    public function get_id_fornecedor()
    {
        return $this->pagamento->get_id_fornecedor();
    }

}
